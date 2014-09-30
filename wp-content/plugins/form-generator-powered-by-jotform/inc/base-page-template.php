	<?php
	if(!class_exists('WP_List_Table')){
    	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	}

 class jc_forms extends WP_List_Table {
     /** ************************************************************************
     * REQUIRED. Set up a constructor that references the parent constructor. We 
     * use the parent reference to set some default configs.
     ***************************************************************************/
  public $jt;
  public $forms;
  public $form_published;
  public $form_deleted;  
  public $form_disabled;
  public $data;
  
   function __construct(){
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'form',     //singular name of the listed records
            'plural'    => 'forms',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
		
		
		
  		$this->update_data();
          
    }
	
	function update_data(){
		error_log ('update data');
		try{
		$jc_settings=get_option( 'jc_setting', '' );
   		$this->jt = new JotForm($jc_settings['jc_api_key']);
		}
		catch(Exception $e){
			//	var_dump($e);
		}
		
		$this->forms =$this->jt->getForms();
		
	 	$this->form_published=array();
		$this->form_deleted=array();
		$this->form_disabled=array();
		$this->data="";
		
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
		
			$request_form=@$_REQUEST['form_status'];
			$form_requested=$this->form_published;
			switch ( $request_form ) {
				case 'disabled':
				$form_requested=$this->form_disabled	;
				break;
				
				case 'trash':
				$form_requested=$this->form_deleted;
				break;
			}
			
		$this->data=$form_requested;
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
        switch($column_name){
            case 'title':
			case 'count':
			case 'submissions':
				//return  $item[$column_name];
				return  sprintf('<a href="?page=%s&form_id=%s"><span class="numberCircle">%s</span></a>','jc-submissions', $item['ID'],$item[$column_name]);
			case 'updated_at':
           /* case 'director':*/
                return $item[$column_name];
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
     * @return string Text to be placed inside the column <td> (movie title only)
     **************************************************************************/
    function column_title($item){
        //Build row actions
      if (@$_REQUEST['form_status']=="trash"){
	   $actions = array(
	   
       // 'restore'    => sprintf('<a href="?page=%1$s&action=restore&form_id=%2$s" class="restoreForm" id="%2$s">Restore</a>','jc-base',$item['ID'])
			);
	  }elseif (@$_REQUEST['form_status']=="disabled"){
	$actions =array(
	'enable'=> sprintf('<a href="?page=%1$s&action=restore&form_id=%2$s" class="enableForm" id="%2$s">Enable</a>','jc-base',$item['ID'])
	);
	  }else{
         $form_url = (isset($item['url']) && !empty($item['url'])) ? $item['url'] : sprintf('http://www.jotform.com/form/%s',$item['ID']);
		 $actions = array(
            'view'    => sprintf('<a href="%s" target="_blank" onclick="%s" class="viewJotForm" >View</a>',$form_url,"window.open(this.href, 'mywin',
'left=20,top=20,width=600,height=600,toolbar=1,resizable=0'); return false;"),
            'edit'    => sprintf('<a href="#" class="editJotForm" id="%s">Edit</a>',$item['ID']),
//            'clone'   => sprintf('<a href="#" class="cloneJotForm" id="%s">Clone</a>',$item['ID']),
//            'delete'  => sprintf('<a href="#" class="deleteJotForm" id="%s" >Delete</a>',$item['ID']),
            'clone'  => sprintf('<a href="?page=%s&form_id=%s&action=clone">Clone</a>','jc-base',$item['ID']),
            'delete'  => sprintf('<a href="?page=%s&form_id=%s&action=delete">Delete</a>','jc-base',$item['ID']),
            			
        );  
	  }
        
        //Return the title contents
        return sprintf('%1$s %3$s',
            /*$1%s*/ $item['title'],
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
     * @return string Text to be placed inside the column <td> (movie title only)
     **************************************************************************/
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
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
        $columns = array(
            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
            'title'     => 'Title',
			'count' 	=> 'Submissions',
			'shortcode'	=> 'Shortcode',
			'updated_at'	=>'Updated', 
 
        );
        return $columns;
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
        $sortable_columns = array(
            'title'     => array('title',false),     //true means it's already sorted
            'count'    => array('count',true),
			'updated_at'    => array('updated_at',true),
         );
        return $sortable_columns;
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
		 if (@$_REQUEST['form_status']=="trash"){
			 $actions=array();
		 } elseif (@$_REQUEST['form_status']=="disabled"){
			 $actions=array();
		 } else{
        $actions = array(
            'delete'    => 'Delete',
			//'restore'   => 'Restore'
        );
		 }
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
        
        //Detect when a bulk action is being triggered...
		error_log($this->current_action());
        switch ($this->current_action())
		{
			
			case 'delete';
			//var_dump($_REQUEST);
				if (isset($_REQUEST['form_id'])){
					$this->jt->deleteForm($_REQUEST['form_id']);
					// var_dump($deleted);
					$this->update_data();
				}elseif (isset($_REQUEST['form'])){
					$forms=$_REQUEST['form'];
					foreach ($forms as $form){
						$this->jt->deleteForm($form);	
						
//						var_dump($form);
					}
					$this->update_data();
				}
			break;
			
			case 'clone';
				if (isset($_REQUEST['form_id'])){
					$this->jt->cloneForm($_REQUEST['form_id']);
					$this->update_data();
				}
							
			case 'restore';
				//$this->jt->setFormProperties($_REQUEST['form_id'],array('status',''));		
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
		$screen = get_current_screen();
		error_log('prepare items');
         /**
         * First, lets decide how many records per page to show
         */
        $per_page = 10;
        
        
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
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
     
  		// preparing query
 		$data=$this->data;
  		
        /**
         * This checks for sorting input and sorts the data in our array accordingly.
         * 
         * In a real-world situation involving a database, you would probably want 
         * to handle sorting by passing the 'orderby' and 'order' values directly 
         * to a custom query. The returned data will be pre-sorted, and this array
         * sorting technique would be unnecessary.
         */
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'title'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');
        
                 
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
		/*
  		$jt = new JotForm($jc_settings['jc_api_key']);
		$forms =$jt->getForms();*/
		try{
		$jc_settings=get_option( 'jc_setting', '' );
   		$jcFormsTable = new jc_forms($jc_settings);
		$key=$jc_settings['jc_api_key'];
		echo "<script> JF.initialize({ apiKey: '$key' }) </script>";
 		}
		catch(Exception $e){
			//echo ($e->getMessage());
 
	
	echo '<div class="error">
       <p><strong>Form Generator is not Active.</strong> <br/> <a class="" href="?page=jc-settings-page">Login or Signup with Jotform here</a> to get started </p>
    </div>';
	
			wp_die('');
		}
		
		function my_admin_notice(){
   
}

		
		?>
<div class="wrap">
	<div id="" class="icon-jotform"><br></div>
	<h2><?php _e( "Form Generator for WordPress", 'dxbase' ); ?></h2>
	<p>We've created a series of beautiful & free templates you can add to your WordPress website in seconds, <a href="http://www.jotform.com/form-templates/user/tmontg1" target="_blank"><strong>browse them here</strong></a>.</p>
	<p> <button   id="embedJotform" class="button button-primary button-large">+ Add Form</button></p>  
  <div id="formViewer"></div>
      <?php
 	 	 
		/*$form_published=array();
		$form_deleted=array();
		$form_disabled=array();
 		foreach ($forms as $form) {
 			$form['shortcode']='[jotform id="'.$form['id'].'"]';
			$form['ID']=$form['id'];
 			switch ($form['status']) {
				case "DELETED":
				$form_deleted[]=$form;
				break;

				case "ENABLED":
				$form_disabled[]=$form;
				break;

				default:
				$form_published[]=$form;
				break;
			}
  		}*/
		
			error_log ('call prepare items');
	 	 	 $jcFormsTable->prepare_items();
			 
echo ' <ul class="subsubsub">'; 
$current="";
if (@$_REQUEST['form_status']=="published" || @$_REQUEST['form_status']=="") $current="current" ;			 
printf('<li class="form_published"><a class="%s" href="?page=%s&form_status=published">My Forms (%s)</a> | </li>',$current,'jc-base',count($jcFormsTable->form_published));

$current="";
if (@$_REQUEST['form_status']=="trash") $current="current" ;	 			 
printf('<li class="form_deleted"><a class="%s" href="?page=%s&form_status=trash">Trash (%s)</a> | </li>',$current,'jc-base',count($jcFormsTable->form_deleted));

$current="";
if (@$_REQUEST['form_status']=="disabled") $current="current" ;	 	 	
printf('<li class="form_disabled"><a class="%s" href="?page=%s&form_status=disabled">Disabled (%s)</a></li>',$current,'jc-base',count($jcFormsTable->form_disabled));
echo '</ul>';
	?>
	 
    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="movies-filter" method="get">
             <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
             <?php  
		//	var_dump($forms);
	
 			 $jcFormsTable->display();
			 ?>
        </form>
</div>