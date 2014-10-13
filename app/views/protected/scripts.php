  <?
    $records_controller = new Records_Controller();
  ?>

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
         <script type="text/javascript">
                  var time_left = null;
                  var seconds_left = null;
                  var minutes_left = null;
                  var time_out_page = null;
                  var time_dec_interval;
                  var time_clear_interval;
                  function time_dec() {
                           time_left--;
                           seconds_left = time_left % 60;
                           minutes_left = Math.floor(time_left / 60);

                           document.getElementById('seconds_left').innerHTML = seconds_left;
                           document.getElementById('minutes_left').innerHTML = minutes_left;

                           if (time_left == 0) {
                                    clearInterval(time_dec_interval);
                                    $('#confirmation_modal_expired_session').modal({show: true});
                           }
                  }
                  function time_clear() {
                           time_left = 900;
                           seconds_left = time_left % 60;
                           minutes_left = Math.floor(time_left / 60);
                           time_out_page = "<?=WWWROOT?>/logout";
                           document.getElementById('seconds_left').innerHTML = seconds_left;
                           document.getElementById('minutes_left').innerHTML = minutes_left;
                           clearInterval(time_clear_interval);
                           clearInterval(time_dec_interval);
                           time_dec_interval = setInterval('time_dec()', 1000);
                  }
                  function time_out_new_login() {
                           $('#confirmation_modal_expired_session').modal({show: false});
                           window.location.href = time_out_page;
                  }
                  time_clear_interval = setInterval('time_clear()', 0);
         </script>
         <script>
                  jQuery(function($){
                           $("#retroclockbox1").flipcountdown({
                                    size:"xs"
                                    <?$records_controller->timeForFinish();?>
                           });
                           /*$('#retroclockbox2').flipcountdown({
                                     size:"xs",
                                    tick:function(){return new Date('');}
                           });*/
                           $('#retroclockbox2').flipcountdown({size:"xs"});
                  })
         </script>



