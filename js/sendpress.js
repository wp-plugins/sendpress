/*
    SendPress Admin Code v0.5
*/
;(function ( $, window, document, undefined ) {
    this.$ = $;
    
    this.init = function($, document){
        $(document).ready(function($){
           spadmin.log("SP Init Started");
         
           //Load SendPress Sections with refence to themselves :)
           spadmin.menu.init.call(spadmin.menu, $);
           spadmin.edit.init.call(spadmin.edit, $);
           spadmin.emailmanager.init.call(spadmin.emailmanager, $);

           spadmin.log("SP Finished Started");
           spadmin.log(spvars);

        });
    }

    this.log= function($msg){
        if(window.console !== undefined){
            console.log($msg);
        }
    }    

    //Stuff used by the SendPress Editor
    this.edit = {
        init: function($){
            spadmin.log('SendPress Editor');
            //Make sure header editors are hidden to start
            this.imagebox = $('#imageaddbox');
            this.textbox = $('#textaddbox');

            //Header Buttons
            $('#addimage').click(function(e){
                e.preventDefault();
                spadmin.edit.imagebox.show();
                spadmin.edit.textbox.hide();
            });

            $('#addtext').click(function(e){
                e.preventDefault();
                spadmin.edit.textbox.show();
                spadmin.edit.imagebox.hide();
            });

            //Image Header Editing
            $('#activate-image').click(function(e){
                e.preventDefault();
                var $img = $('#upload_image').val();
                if($img.length > 0){
                    $('#active_header').attr('value','image');
                    $('#post').submit();
                }else{
                    $('#imageaddbox .error').show();
                }
            });

            $('#close-image').click(function(e){
                e.preventDefault();
                spadmin.edit.imagebox.hide();
            });

            //Txt Header Editing
            $('#activate-text').click(function(e){
                e.preventDefault();
                $('#active_header').attr('value','text');
                $('#post').submit();
            });
            
            $('#save-text').click(function(e){
                e.preventDefault();
                $('#post').submit();

            });
        }
    }

    //General Menu's
    this.menu = {
        init: function($){

            $('#next-style').click(function(e){
                e.preventDefault();
                $('#save-type').val('save-style');
                $('#post').submit();
            });

            $('#save-edit-email').click(function(e){
                e.preventDefault();
                $('#save-action').val('save-edit');
                $('#post').submit();
            });

            $('#confirm-send').click(function(e){
               e.preventDefault();
               $('#post').submit();
            });

            $('#save-send-email').click(function(e){
                e.preventDefault();
                $('#save-action').val('save-send');

                $('#post').submit();
            });

            $('#save-style-email').click(function(e){
                e.preventDefault();
                $('#save-action').val('save-style');

                $('#post').submit();
            });


            $('#save-update').click(function(e){
                e.preventDefault();
              
                $('#post').submit();

            });

        }
    }

    this.emailmanager = {
        init:function($){
            $('.view-btn').click(function(e) { 
                e.preventDefault();
                $v = $(this).attr('href')+'?TB_iframe=1';
                tb_show($(this).attr('title'), $v );
            });
        }
    }

    this.queue = {
        count: 0,
        total: 0,
        updatetotal:function(){

            $.post(
                spvars.ajaxurl,
                {
                    action:'sendpress-sendcount',
                    spnonce: spvars.sendpressnonce
                }, function(response) {
                    try {
                        
                        response = $.parseJSON(response);
                     
                        var $qt = $("#queue-total");
                        spadmin.queue.total = parseInt(response.total);
                        $qt.html(response.total);
                         
                    } catch (err) {
                        spadmin.log(err);
                    }

                    
                 }
            );

        },
        sendbatch: function(){
            $.post(
                spvars.ajaxurl,
                {
                    action:'sendpress-sendbatch',
                    spnonce: spvars.sendpressnonce
                }, 
                function(data){
                    spadmin.queue.batchsent(data);
                }); 
        },
        batchsent: function(response){
            response = $.parseJSON(response);
            spadmin.log(response);
            if(parseInt(response.attempted) > 0){
                spadmin.queue.count = spadmin.queue.count + parseInt(response.sent);
                var $qt =$("#queue-sent");
                $qt.html(spadmin.queue.count);
                $p = parseInt( spadmin.queue.count / spadmin.queue.total * 100 );
                $('#sendbar-inner').css('width', $p+'%');

                spadmin.queue.sendbatch();
                spadmin.log('We should check for more emails');
            } else {
                spadmin.queue.closesend();
                spadmin.log('Should die');
            }
        },
        closesend:function(){
            $('#sendpress-sending').modal('hide');
        }
    }

    this.init( $, document);

}).call( window.spadmin=window.spadmin || {}, jQuery, window, document );














jQuery(document).ready(function($) {

    /*
    tinymce.dom.Event.add(document, 'blur', function(e) {
                        alert("blur");
                    });

        //tinymce.dom.Event._add(document,"focus",function(){ alert('asdf'); });
        /*
        wpActiveEditor.onClick.add(function(ed, l) {
                  console.debug('Editor contents was modified. Contents: ' + l.content);
          });
        /*

        $('#test').click(function(){
           console.debug(tinyMCE.activeEditor.getContent());
            $('#wp-content-wrap').toggle();
            tinyMCE.
           alert($c);

        });  
         

        jQuery('.wp-editor-wrap').mousedown(function(e){
            wpActiveEditor = this.id.slice(3, -5);
        });
*/ 
                //Build the Reset Button Actions
        $(".reset-line").click(function(e){
            var $reset = $(this);
            var id = $reset.attr("data-id");
            
            //console.log(tinyMCE.get('content'));

            //$('#content_ifr' ).contents().find('a').attr('style','color:#ff0000');

            switch($reset.attr('data-type')){
                case "cp":
                    e.preventDefault();
                    var cp = $.farbtastic('#'+ id +'_colorpicker');
                    cp.setColor($('#default_'+ id ).val());
                break;
                case "border":
                    e.preventDefault();
                    var cp = $.farbtastic('#'+ id +'_colorpicker');
                    cp.setColor($('#default_'+ id + '_color').val());
                    $('#' + id +'_style').val($('#default_'+ id + '_style').val());
                    $('#' + id +'_width').val($('#default_'+ id + '_width').val());
                    //alert('reset border');
                break;
                
                case "image":
                    $('#'+ id +'_id').val("");
                    $('#'+ id +'_preview').toggle();
                    
                break;
                               
            }
            
        });


        //Build ColorPickers
        $('.cpcontroller').each(function(i){
            var $element = $(this);
            var id = $element.attr('data-id');
            var $holder = $('#pickholder_' + id);
            var $fb = $('#'+ id +'_colorpicker').farbtastic($element);
            // $.farbtastic('#'+ id +'_colorpicker').linkTo( cb  );
            
            if( $element.attr('iframe') == 'true' ) {
                console.log( $element.val() );
                // $('#content').html('data fix');
                    
                //$('#content a').attr('style','color:' + $element.val() ).attr('data-mce-style','color:' + $element.val() );
                if(window.tinyMCE !== undefined){
                    $('#content_ifr' ).contents().find('a').attr('style','color:' + $element.val() ).attr('data-mce-style','color:' + $element.val() );
                } else {
                    $( $element.attr('link-id') ).css($element.attr('css-id') , $element.val() );
                }

            } else {
                $( $element.attr('link-id') ).css($element.attr('css-id') , $element.val() );
            }

            $element.focus(function(){
                var p = $element.position();
                $holder.css('top',p.right+"px").css('left',p.left+"px").toggle('slow');
            })
            .change(function(){
                $item = $(this);
                if( $item.attr('iframe') == 'true' ){
                     if(window.tinyMCE !== undefined){
                        $('#content_ifr' ).contents().find('a').attr('style','color:' + $element.val() ).attr('data-mce-style','color:' + $element.val() );
                        } else {
                        $( $element.attr('link-id') ).css($element.attr('css-id') , $element.val() );
                        }
                } else {
                    $( $item.attr('link-id') ).css($item.attr('css-id') , $item.val() );
                }
            })
            .blur(function(){
                var p = $element.position();
                $holder.css('top',p.right+"px").css('left',p.left+"px").toggle('slow');
            })
            .keyup(function(){
                var _hex = $element.val(), hex = _hex;
                if ( hex[0] != '#' ){
                    hex = '#' + hex;
                }
                hex = hex.replace(/[^#a-fA-F0-9]+/, '');
                if ( hex != _hex ){
                    $element.val(hex);
                }
                if ( hex.length == 4 || hex.length == 7 ){
                        var cp = $.farbtastic('#'+ id +'_colorpicker');
                        cp.setColor(hex);
                }
            });
            $holder.hide();
        });

        //list edit js
        $(".edit-list").click(function(e){
            e.preventDefault();

            $(".edit-list-form").each(function(){
                $(this).closest("tr").remove();
            });

            var $btn = $(this),
                $row = $btn.closest("tr"),
                listID = $btn.attr("listid"),
                name = $btn.attr('name'),
                pub = $btn.attr('public'),
                url = $btn.attr("href");

            jQuery.get(url+'?listid='+listID+'&name='+name+"&public="+pub, function(data) {
                $row.after(data);

                var $form = $(".edit-list-form");
                $form.animate({height:30},750);
            });
        });

        $("#cancel-edit-list").live('click',function(e){
            e.preventDefault();

            $(this).closest("tr").remove();
        });

        $('.edit-list-checkbox').live('click',function(){
            if( $(this).is(':checked') ){
                $(this).val(1);
            }else{
                $(this).val(0);
            }
        });

        $("#save-edit-list").live('click',function(e){
            e.preventDefault();

            var list = {},
                $form = $(this).parent('.edit-form');

            list['id'] = $form.find('#list-id').val();
            list['name'] = $form.find('#list-name').val();
            list['public'] = $form.find('#list-public').val();
            list['action'] = 'sendpress_save_list';

            //console.debug(list);

            jQuery.post(spvars.ajaxurl, list, function(response){
                
                try {
                    response = $.parseJSON(response);
                } catch (err) {
                    // Invalid JSON.
                    if(!jQuery.trim(response).length) {
                        response = { error: 'Server returned empty response during charge attempt'};
                    } else {
                        response = {error: 'Server returned invalid response:<br /><br />' + response};
                    }
                }

                if(response['success']){
                    location.reload();
                }else{
                    //possibly display an error here
                }
            });

        });





    $('#sendpress-sending').on('show',function(){
        $.post(
            spvars.ajaxurl,
            {
                action:'sendpress-stopcron',
                spnonce: spvars.sendpressnonce
            },
            function(response){
                try {
                    response = $.parseJSON(response);
                } catch (err) {
                    // Invalid JSON.
                    if(!$.trim(response).length) {
                        response = { error: 'Server returned empty response during charge attempt'};
                    } else {
                        response = {error: 'Server returned invalid response:<br /><br />' + response};
                    }
                }
                spadmin.queue.updatetotal();
                spadmin.queue.sendbatch();
            }

        );
    }).on('hidden', function () {
        $('#sendbar-inner').css('width', '100%');
        location.reload();
        // do something…
    }).on('shown', function(){ 
        spadmin.queue.count = 0;
        $('#sendbar-inner').css('width', '0%');
    });




     
});

