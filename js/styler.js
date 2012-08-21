jQuery(document).ready(function($) {

        $('#addimageupload').click(function(e) {
            e.preventDefault();
            $btn = $(this);
            formfield = jQuery('#upload_image').attr('name');
            formID = $btn.attr('rel');
            tb_show('SendPress', 'media-upload.php?post_id='+formID+'&amp;is_sendpress=yes&amp;TB_iframe=true');
            return false;
        });
        
        spadmin.send_to_editor = window.send_to_editor;

        window.send_to_editor = function(html) {
            if( jQuery('#imageaddbox').is(":visible")   ){
                imgurl = jQuery('img',html).attr('src');
                jQuery('#upload_image').val(imgurl);
                tb_remove();
            } else {
                spadmin.send_to_editor(html);
            }

        };

        $('#upload_image').change(function(){
              $('#html-header').html('<img src="'+ $(this).val() +'" />');
        });

            if(tinyMCE){
                tinyMCE.onAddEditor.add(function(mgr,ed) {
                // alert(ed);// do things with editor ed
                    ed.onChange.add(function(ed, l) {
                        $('#content_ifr' ).contents().find('a').attr('style','color:' + $('#sp_content_link_color').val() ).attr('data-mce-style','color:' + $('#sp_content_link_color').val() );
                    });
                });
            }
        
});