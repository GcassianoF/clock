	<script type="text/javascript">
		$('.btn-red').click(function(e){
			var href = $(this).attr('href');
			$('#confirmation_modal').modal({show: true});
			$('#confirm_danger').click(function(e){
				window.location = href;
				e.preventDefault();
			});
			e.preventDefault();
		});
	</script>
        <script type="text/javascript">

            jQuery(document).ready(function($) {

                $('a.avail-color').click(function(){
                    return false;
                })


                /* print
          --------------------------- */
                $('#print').click(function(){
                    window.print();
                })
                /* end print
          --------------------------- */

                /* pdf
          --------------------------- */
                $('#pdf').click(function(){
                    // your pdf action here...
                    alert('your pdf action here...');
                })
                /* end print
          --------------------------- */

                /* change color
          --------------------------- */
                $('.controller2 a').click(function(){
                    color = $(this).attr('title');

                    $('#resume-head').attr('class', 'grd-'+color);
                    $('.title2 h3, .title2 p').attr('class', 'border-'+color);
                });
                /* end change color
          --------------------------- */
            });
    
        </script>
