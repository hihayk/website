require 'maruku'
require 'nokogiri'
 
module Jekyll
 
  class ExcerptBuilder < Generator
    safe true
    priority :high
    EXCERPT_LENGTH = 160
 
    def generate(site)
      site.posts.map! do |post|
 
        unless post.data['excerpt']
          html = ::Maruku.new(post.content).to_html 
          excerpt = ::Nokogiri::HTML(html).text[0..EXCERPT_LENGTH].gsub(/\n/, ' ')
          post.data['excerpt'] = excerpt.strip
        end
 
        post.data['excerpt'] += '&hellip;'
        post
      end
    end
 
  end
 
end