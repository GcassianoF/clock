<?php
/*
Author: Giceu Cassiano

Description:
	Defines methods that generates HTML elements
*/
class HTML extends DAO
{
	function main_content_START($class=NULL, $innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '<div class=" '.$class.' ">';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    function main_content_END($innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '</div>';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    function container_START($class=NUll, $innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '<div class=" '.$class.' ">';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    function container_END($innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '</div>';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    function row_START($class=NULL, $innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '<div class=" '.$class.' ">';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    function row_END($innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '</div>';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    function span_START($span=NULL, $class=NULL, $style=NULL, $innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '<div class="span'.$span.' '.$class.' " '.$style.' >';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    function span_END($innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '</div>';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    function box_START($icon='icon-home',$title='Put Title at the second position of the function!', $style, $innerSPAN, $class=NULL, $innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '<div class="box '.$class.' ">';
        echo '  <div class="box-header" '.$style.'>';
        echo '      <span class="title"><i class='.$icon.'></i> '.$title.'</span>';
        echo '  '.$innerSPAN;
        echo '  </div>';
        echo '  <div class="box-content">';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    function box_END($innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '</div></div>';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    

    /*atributos HTML referente a criação da pagina "show.php"*/
    function show_container_START($innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '<div class="container">';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    function show_container_END($innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '</div>';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    function show_header_START($innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '<div id="resume-head" class="grd-black"><div class="row-fluid">';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    function show_header_END($innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '</div></div>';
        echo $innerHTML_AFTER;
        return FALSE;        
    }

    function show_config()
    {
        echo '<div class="controller2">
                <button id="colorir" class="btn btn-block btn-inverse"><i class="icon-cogs"></i> Configurar</button>
                <div id="paint">
                    <ul>
                        <li><a title="black" id="black" href="#black" class="avail-color bg-black"></a></li>
                        <li><a title="teal" id="teal" href="#teal" class="avail-color bg-teal"></a></li>
                        <li><a title="win8" id="win8" href="#win8" class="avail-color bg-win8"></a></li>
                        <li><a title="blue" id="blue" href="#blue" class="avail-color bg-blue"></a></li>
                        <li><a title="purple" id="purple" href="#purple" class="avail-color bg-purple"></a></li>
                        <li><a title="purple-dark" id="purple-dark" href="#purple-dark" class="avail-color bg-purple-dark"></a></li>
                        <li><a title="red" id="red" href="#red" class="avail-color bg-red"></a></li>
                        <li><a title="orange" id="orange" href="#orange" class="avail-color bg-orange"></a></li>
                        <li><a title="green" id="green" href="#green" class="avail-color bg-green"></a></li>
                        <li><a title="sky" id="sky" href="#sky" class="avail-color bg-sky"></a></li>
                    </ul>
                </div>
            </div>';
        return FALSE;
    }

    function show_content_START($innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '<div id="resume-content">
                <div class="row-fluid profile">';
        echo $innerHTML_AFTER;
        return FALSE;           
    }

    function show_content_END($innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '</div></div>';
        echo $innerHTML_AFTER;
        return FALSE;           
    }

/*    function show_content_title($title='Title', $icon='icon-user')
    {
        echo '<div class="span6">
                <div class="left">
                    <h3 class="title2-icon pull-left"><i class="'.$icon.'"></i></h3>
                    <div class="title2">
                        <h3>'.$title.'</h3>
                    </div>
			<div class="span6">
                			<div class="left">
				</div>
			</div>
         		</div>
           	 </div>';
        return FALSE;
    }*/

function show_content_title($title='Title', $icon='icon-user',$after=null)
    {
        echo '<div class="span6">
                <div class="left">
                    <h3 class="title2-icon pull-left"><i class="'.$icon.'"></i></h3>
                    <div class="title2">
                        <h3>'.$title.'</h3>
                    </div>
			<div class="span6">
                <div class="left">
			'.$after.'
</div></div>
                </div>
            </div>';
        return FALSE;
    }

    function show_content_box_START($innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '<div class="span6">
                <div class="right">';
        echo $innerHTML_AFTER;
        return FALSE;           
    }

    function show_content_box_END($innerHTML_BEFORE=NULL, $innerHTML_AFTER=NULL)
    {
        echo $innerHTML_BEFORE;
        echo '</div></div>';
        echo $innerHTML_AFTER;
        return FALSE;           
    }

    function show_content_field($field=FALSE, $icon=FALSE, $result=FALSE)
    {
        echo '<div class="title2 display-table">
                <p>'.$field.'</p>
                <span class="pull-right"><i class="'.$icon.'"></i>&nbsp;'.$result.'</span>
            </div>';
        return FALSE;
    }
    function show_content_field_left($field=FALSE, $icon=FALSE, $result=FALSE)
    {
        echo '<div class="title2 display-table">
                <p>'.$field.'</p>
                <span class="pull-left"><i class="'.$icon.'"></i>'.$field.'&nbsp;'.$result.'</span>
            </div>';
        return FALSE;
    }
    /*atributos HTML referente a criação da pagina "show.php"*/

}
?>