<?php
	if(!class_exists('WP_List_Table')){
      	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	}
	/** Include PHPExcel */
	require_once(JC_PATH_INCLUDES . '/PHPExcel.php' );

class jc_submissions extends WP_List_Table {
     /** ************************************************************************
     * REQUIRED. Set up a constructor that references the parent constructor. We 
     * use the parent reference to set some default configs.
     ***************************************************************************/
	var $data="";  
	var $columns="";
	var $sortable_columns;
	var $hidden_columns;
  public $jt;
  public $forms;
  public $form_published;
  public $form_deleted;  
  public $form_disabled;
  public $submmissions;
  public $column_title;
  public  $rendererName;
  public $rendererLibrary;
  public $rendererLibraryPath;

	 
    function __construct(){
        global $status, $page;
		 
         //Set parent defaults
        parent::__construct( array(
            'singular'  => 'submission',     //singular name of the listed records
            'plural'    => 'submissions',    //plural name of the listed records
            'ajax'      => true        //does this table support ajax?
        ) );
     	$this->update_data();   
    }
    
	function update_data(){
		$jc_settings=get_option( 'jc_setting', '' );
   		$this->jt = new JotForm($jc_settings['jc_api_key']);
		$this->forms =$this->jt->getForms();
 		$this->submmissions=array();
		$this->form_published=array();
		$this->form_deleted=array();
		$this->form_disabled=array();
		$this->data=array();
		$this->column_title=array();
		foreach ($this->forms as $form) {
 			$form['shortcode']='[jotform id="'.$form['id'].'"]';
			$form['ID']=$form['id'];
 			switch ($form['status']) {
				case "DELETED":
				$this->form_deleted[]=$form;
				break;
				case "DISABLED":
				$this->form_disabled[]=$form;
				break;
 				default:
				$this->form_published[]=$form;
				break;
			}
  		}
		
		// get submissions
		if (isset($_REQUEST['form_id'])) {
 					 $form_id=$_REQUEST['form_id'];
 					 $this->submmissions=$this->jt->getFormSubmissions($form_id,$offset = 0, $limit =1000);
					 		$form_name=$this->jt->getForm($_REQUEST['form_id']);
							$form_name=$form_name['title'];
  		}
 
	// get columns title
					    $answers=array();
  						$column_title=array();
						$export_columns=array();
					 //$this->submmissions=array();
 						 
					 if (count($this->submmissions) > 0  && isset($this->submmissions[0]['answers']))
					 {
						// get columns title
						if (isset($this->submmissions[0]['answers'])){
 						 } // endif answers
						 
						$columns=$this->submmissions[0]['answers'];
						$columns=array_values($columns);
						// unset ($columns['0']);
						$column_title=array( 'cb'        => '<input type="checkbox" />');
							foreach ($columns as $column){
								 $column_title=array_merge($column_title,array(sanitize_title($column['text'])=>$column['text']));
								 $export_columns[]=$column['text'];
							}
						
						$this->column_title=array_merge($column_title,array('form_id' => 'Form ID'));	
						$this->column_title=array_merge($column_title,array('created_at' => 'Date'));
						$export_columns=array_merge($export_columns,array('Date'));
						}
					
		// get answers <br />
				 		$answers=array();
						$export_data=array();
						/* var_dump(array_key_exists('answers', $this->submmissions));
 						 var_dump(($this->submmissions));*/
						
						foreach ($this->submmissions as $submmission){
							if (array_key_exists('answers', $submmission)){
								$ans=array_values($submmission['answers']);
 								// unset($ans['0']);
 								$gtans=array('ID'=>$submmission['id']);
								$gtans2=array();
								  foreach($ans as $an){
									  $key=sanitize_title($an['text']);
									  $val="";
									   if (is_array($an['answer'])){
										   $val=implode(" ",$an['answer']);
									   }else{
										   $val=$an['answer'];
									   }
                                       // Check if $val is string, is valid URL and create link
                                       if (!empty($val) && is_string($val) && parse_url_if_valid($val))
                                           $val = '<a href="' . $val . '">' . $val . '</a>';

 									  $gtans2=array_merge($gtans2,array($key=>$val)); 
									  $gtans=array_merge($gtans,array($key=>$val));
									  	
								  }
 									$gtans=array_merge($gtans,array('form_id'=>$submmission['form_id']));
									$gtans=array_merge($gtans,array('created_at'=>$submmission['created_at']));
									$gtans2=array_merge($gtans2,array('created_at'=>$submmission['created_at']));
									$export_data[]=$gtans2;
									$answers[]=$gtans;	
						}
						 }
						$this->data=$answers;
		
	 	// sortable column
		 						$sc=array();
								$cts=$column_title;
								unset($cts['cb']);
 								foreach ($cts as $key=>$val){
 									$sc[$key]=array($key,TRUE); 
								}
					$this->sortable_columns=$sc;
 				
		// hidden 
		$this->hidden_columns=array('form_id');		
 		
		// export to excel
 		if (isset($_REQUEST['exportTo'])  ){
 				
				//$this->rendererName = PHPExcel_Settings::PDF_RENDERER_TCPDF;
				//$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
				$this->rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
				//$this->rendererLibrary = 'tcPDF.php';
				//$rendererLibrary = 'mPDF.php';
				//$rendererLibrary = 'domPDF0.6.0beta3';
				$this->rendererLibrary ='dompdf';
				$this->rendererLibraryPath = JC_PATH_INCLUDES.'/PHPExcel/Writer/PDF/'. $this->rendererLibrary;

			if ($_REQUEST['exportTo']=='xls'){	
				$flname=$form_name.' ('.date("Y-m-d H-i-s").')'.'.xls';
			}else if ($_REQUEST['exportTo']=='pdf'){
 				
				if (! PHPExcel_Settings::setPdfRenderer($this->rendererName,$this->rendererLibraryPath)) {
						die("Unable to load PDF Rendering library");
						exit();
					}	
					$flname=$form_name.' ('.date("Y-m-d H-i-s").')'.'.pdf';
 			 }
			
 			
  			 // Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
			
			 ob_start();
			// Set document properties
			$objPHPExcel->getProperties()->setCreator("Form Generator - Powered by Jotform")
										 ->setLastModifiedBy("Form Generator - Powered by Jotform")
										 ->setTitle($flname)
										 ->setSubject($flname)
										 ->setDescription("")
										 ->setKeywords("")
										 ->setCategory("");
			
			// Add First Rows / Column Title
			$ndx=0;
			foreach ($export_columns as $column){
				 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ndx,1, $column);
				// set background color for header
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($ndx,1)->applyFromArray(
				array(
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'c6efce')
				)));
					
				 $ndx++;
			}
			$row=2;
			foreach ($export_data as $datas) {
				$col=0;
 				foreach ($datas as $data) {
					 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $data);
 					 $col++;
				}
				$row++;
			} 
			
			
 			// Auto width
			if ($_REQUEST['exportTo']=='xls'){	
				for ($x=0; $x<=count($export_columns); $x++)
				{
				 $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($x)->setAutoSize(true);
				}
			}	
			
			if ($_REQUEST['exportTo']=='pdf'){	
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			}
		 
			 
			 // Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle('Submissions');
			
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
  		 
		// $data=ob_get_contents();
		
		 // Redirect output to a client's web browser (Excel5)
/*		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$flname.'"');
		header('Cache-Control: max-age=0'); */
	
		//echo $data; 
			
			if ($_REQUEST['exportTo']=='xls'){	
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			}else if ($_REQUEST['exportTo']=='pdf'){
 				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
 			}
			//$objWriter->save('php://output'); 
			$objWriter->save(JC_PATH.'/export/'.$flname); 
			 ob_end_clean();	  
 	 	 
	//	printf ('<a href="%s">%s</a>',JC_URL.'/'.$flname, $flname);
		
				if ($_REQUEST['exportTo']=='xls'){	
			printf ('<div id="message" class="updated"><p>Excel Submissions Ready ! <a target="blank" href="%s">Download Now</a></p></div>',JC_URL.'/export/'.$flname);
				}else if ($_REQUEST['exportTo']=='pdf'){
		printf ('<div id="message" class="updated"><p>PDF Submissions Ready ! <a target="blank" href="%s">Download Now</a></p></div>',JC_URL.'/export/'.$flname);
				}
 			
 		} // endif export to excel
 		
	}
     /** ************************************************************************
     * Recommended. This method is called when the parent class can't find a method
     * specifically build for a given column. Generally, it's recommended to include
     * one method for each column you want to render, keeping your package class
     * neat and organized. For example, if the class needs to process a column
     * named 'title', it would first see if a method named $this->column_title() 
     * exists - if it does, that method will be used. If it doesn't, this one will
     * be used. Generally, you should try to use custom column methods as much as 
     * possible. 
     * 
     * Since we have defined a column_title() method later on, this method doesn't
     * need to concern itself with any column with a name of 'title'. Instead, it
     * needs to handle everything else.
     * 
     * For more detailed insight into how columns are handled, take a look at 
     * WP_List_Table::single_row_columns()
     * 
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     **************************************************************************/
    function column_default($item, $column_name){
		
       /* switch($column_name){
            case 'full-name':
            case 'e-mail':
			case 'phone-number':
                return $item[$column_name];
             default:
                return print_r($item,true);  
        }*/
		$actions = array(
            'delete'    => sprintf('<a href="?page=%s&action=%s&form_id=%s&submission=%s">Delete</a>',$_REQUEST['page'],'delete',$_REQUEST['form_id'],$item['ID']),
        );
	 
		$op=array_keys($this->column_title);
		$op=$op[1];
		   switch($column_name){
             case $op:
                //Return the title contents
				return sprintf('%1$s %3$s',
					/*$1%s*/ $item[$op] ,
					/*$2%s*/ $item['ID'],
					/*$3%s*/ $this->row_actions($actions)
				);
             default:
                return $item[$column_name]; 
        }
		
		
    }
    
        
    /** ************************************************************************
     * Recommended. This is a custom column method and is responsible for what
     * is rendered in any column with a name/slug of 'title'. Every time the class
     * needs to render a column, it first looks for a method named 
     * column_{$column_title} - if it exists, that method is run. If it doesn't
     * exist, column_default() is called instead.
     * 
     * This example also illustrates how to implement rollover actions. Actions
     * should be an associative array formatted as 'slug'=>'link html' - and you
     * will need to generate the URLs yourself. You could even ensure the links
     * 
     * 
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (submission title only)
     **************************************************************************/
    function column_full_namex($item){
	 
        //Build row actions
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&submission=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&submission=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID']),
        );
        
        //Return the title contents
        return sprintf('%1$s %3$s',
            /*$1%s*/ $item['full_name'],
            /*$2%s*/ $item['ID'],
            /*$3%s*/ $this->row_actions($actions)
        );
		
		 
    }
    
    /** ************************************************************************
     * REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
     * is given special treatment when columns are processed. It ALWAYS needs to
     * have it's own method.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (submission title only)
     **************************************************************************/
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("submission")
            /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
        );
    }
    
    
    /** ************************************************************************
     * REQUIRED! This method dictates the table's columns and titles. This should
     * return an array where the key is the column slug (and class) and the value 
     * is the column's title text. If you need a checkbox for bulk actions, refer
     * to the $columns array below.
     * 
     * The 'cb' column is treated differently than the rest. If including a checkbox
     * column in your table you must create a column_cb() method. If you don't need
     * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_columns(){
          return $this->column_title;
    }
    
    /** ************************************************************************
     * Optional. If you want one or more columns to be sortable (ASC/DESC toggle), 
     * you will need to register it here. This should return an array where the 
     * key is the column that needs to be sortable, and the value is db column to 
     * sort by. Often, the key and value will be the same, but this is not always
     * the case (as the value is a column name from the database, not the list table).
     * 
     * This method merely defines which columns should be sortable and makes them
     * clickable - it does not handle the actual sorting. You still need to detect
     * the ORDERBY and ORDER querystring variables within prepare_items() and sort
     * your data accordingly (usually by modifying your query).
     * 
     * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
     **************************************************************************/
    function get_sortable_columns() {
         return $this->sortable_columns;
    }
    
    
    /** ************************************************************************
     * Optional. If you need to include bulk actions in your list table, this is
     * the place to define them. Bulk actions are an associative array in the format
     * 'slug'=>'Visible Title'
     * 
     * If this method returns an empty value, no bulk action will be rendered. If
     * you specify any bulk actions, the bulk actions box will be rendered with
     * the table automatically on display().
     * 
     * Also note that list tables are not automatically wrapped in <form> elements,
     * so you will need to create those manually in order for bulk actions to function.
     * 
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }
    
    
    /** ************************************************************************
     * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
     * For this example package, we will handle it in the class to keep things
     * clean and organized.
     * 
     * @see $this->prepare_items()
     **************************************************************************/
    function process_bulk_action() {
		switch ($this->current_action())
		{
			
			case 'delete';
			//var_dump($_REQUEST);
				if (isset($_REQUEST['form_id']) && $_REQUEST['submission']){
					$this->jt->deleteSubmission($_REQUEST['submission']);
					$this->update_data();
				/*}elseif (isset($_REQUEST['form'])){
					$forms=$_REQUEST['form'];
					foreach ($forms as $form){
						$this->jt->deleteForm($form);	
					}
					$this->update_data();*/
				}
			break;
		}
        
    }
    
    
    /** ************************************************************************
     * REQUIRED! This is where you prepare your data for display. This method will
     * usually be used to query the database, sort and filter the data, and generally
     * get it ready to be displayed. At a minimum, we should set $this->items and
     * $this->set_pagination_args(), although the following properties and methods
     * are frequently interacted with here...
     * 
     * @global WPDB $wpdb
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     **************************************************************************/
    function prepare_items() {
        global $wpdb; //This is used only if making any database queries

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = 20;
        
        
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = $this->hidden_columns;
        $sortable = $this->get_sortable_columns();
        
         /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);
        
        
        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        $this->process_bulk_action();
        
        
        /**
         * Instead of querying a database, we're going to fetch the example data
         * property we created for use in this plugin. This makes this example 
         * package slightly different than one you might build on your own. In 
         * this example, we'll be using array manipulation to sort and paginate 
         * our data. In a real-world implementation, you will probably want to 
         * use sort and pagination data to build a custom query instead, as you'll
         * be able to use your precisely-queried data immediately.
         */
         $data = $this->data;
                
        /**
         * This checks for sorting input and sorts the data in our array accordingly.
         * 
         * In a real-world situation involving a database, you would probably want 
         * to handle sorting by passing the 'orderby' and 'order' values directly 
         * to a custom query. The returned data will be pre-sorted, and this array
         * sorting technique would be unnecessary.
         */
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'created_at'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'desc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');
        
        /***********************************************************************
         * ---------------------------------------------------------------------
         * vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
         * 
         * In a real-world situation, this is where you would place your query.
         * 
         * ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
         * ---------------------------------------------------------------------
         **********************************************************************/
        
                
        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */
        $current_page = $this->get_pagenum();
        
        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count($data);
        
        
        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        
        
        
        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;
        
        
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
    
}
try{
$jc_settings=get_option( 'jc_setting', '' );
$key=$jc_settings['jc_api_key'];
print "<script> JF.initialize({ apiKey: '$key' }) </script>";
$jtc = new jc_submissions($jc_settings['jc_api_key']);
$forms=$jtc->form_published;	
}
		catch(Exception $e){
			 echo ($e->getMessage());
 			echo '<div class="error">
       <p><strong>Form Generator is not Active.</strong> <br/> <a class="" href="?page=jc-settings-page">Login or Signup with Jotform here</a> to get started </p>
    </div>';
	
			wp_die('');
		}

?>
  <div class="wrap">
        
        <div id="" class="icon-jotform"><br/></div>
        <h2>Submissions | Form Generator for WordPress</h2>
         <p></p>
      
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="submissions-filter" method="get">
			 
            <label>Select Form </label><select name="form_id">
            <?php  	
			foreach ($forms as $form) {
				$sel="";
				if (@$_REQUEST['form_id']==$form['id'])
				{
					$sel='selected="selected"';
				}
			printf('<option %4$s value="%1$s">%2$s (%3$s)</option>',$form['id'],$form['title'],$form['count'],$sel);
				}
			?>
            
            </select>
			<?php  ?>
			<input type="submit" name="" id="doaction" class="button action" value="View">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <button name="exportTo" class="button action" value="xls" id="exportTo">Export to Excel</button>
        
        <div class="ajax_response">
        <?php //fecth_submission()
  		$jtc->prepare_items();
		$jtc->display();
 		 ?>
        </div>
        </form>
     </div>
<?php
	function plus_to_dash($title) {
        return str_replace('-', '_', $title);
	}
	add_filter('sanitize_title', 'plus_to_dash',10,3);

    /** ************************************************************************
    * This function is called for checking if URL is valid
    * 
    * @param string $url An URL string
    * @return string URL if URL is valid or NULL if URL is not valid
    **************************************************************************/
    function parse_url_if_valid($url)
    {
        $arUrl = parse_url($url);
        $result = null;

        if (!array_key_exists("scheme", $arUrl) || !in_array($arUrl["scheme"], array("http", "https"))) $arUrl["scheme"] = "http";

        if (array_key_exists("host", $arUrl) && !empty($arUrl["host"])) {
            $result = sprintf("%s://%s%s", $arUrl["scheme"], $arUrl["host"], $arUrl["path"]);
        } else if (preg_match("/^\w+\.[\w\.]+(\/.*)?$/", $arUrl["path"])) {
            $result = sprintf("%s://%s", $arUrl["scheme"], $arUrl["path"]);
        }

        if ($result && empty($result["query"])) $result .= sprintf("?%s", $arUrl["query"]);

        return $result;
    }
