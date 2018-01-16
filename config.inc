<?php
/**
* URL PDF
*/
define("API_URL", "http://www.tourinperu.com/it-manual/availability.php");
function days($day,$lang="en")
{
    $days = array(
        '1' =>  array('es'=> 'Do','en'=>'Sun','pt'=>'Dom'),
        '2' =>  array('es'=> 'Lu','en'=>'Mon','pt'=>'Seg'),
        '3' =>  array('es'=> 'Ma','en'=>'Tue','pt'=>'Ter'),
        '4' =>  array('es'=> 'Mi','en'=>'Wed','pt'=>'Qua'),
        '5' =>  array('es'=> 'Ju','en'=>'Thu','pt'=>'Qui'),
        '6' =>  array('es'=> 'Vi','en'=>'Fri','pt'=>'Sex'),
        '7' =>  array('es'=> 'Sa','en'=>'Sat','pt'=>'Sab')
        );
    return $days[$day][$lang];
}
function incatrail($it,$lang="en")
{
    $names = array(
        '1' =>  array('es'=> 'Camino Inca 2 Días','en'=>'Inca Trail 2 Days','pt'=>'Inca Trail 2 Days'),
        '2' =>  array('es'=> 'Camino Inca 4 Días','en'=>'Inca Trail 4 Days','pt'=>'Inca Trail 4 Days')
        );
    return $names[$it][$lang];
}
function months($month,$lang="en")
{
    $months = array(
        '1' =>  array('es'=> 'Enero','en'=>'January','pt'=>'Janeiro'),
        '2' =>  array('es'=> 'Febrero','en'=>'February','pt'=>'Fevereiro'),
        '3' =>  array('es'=> 'Marzo','en'=>'March','pt'=>'Março'),
        '4' =>  array('es'=> 'Abril','en'=>'April','pt'=>'Abril'),
        '5' =>  array('es'=> 'Mayo','en'=>'May','pt'=>'Maio'),
        '6' =>  array('es'=> 'Junio','en'=>'June','pt'=>'Junho'),
        '7' =>  array('es'=> 'Julio','en'=>'July','pt'=>'Julho'),
        '8' =>  array('es'=> 'Agosto','en'=>'August','pt'=>'Agosto'),
        '9' =>  array('es'=> 'Setiembre','en'=>'September','pt'=>'Setembro'),
        '10' =>  array('es'=> 'Octubre','en'=>'October','pt'=>'Outubro'),
        '11' =>  array('es'=> 'Noviembre','en'=>'November','pt'=>'Vovembro'),
        '12' =>  array('es'=> 'Diciembre','en'=>'December','pt'=>'Dezembro'),
        );
    return $months[$month][$lang];
}
function words($word,$lang)
{
    $words = array(
        'pre_book' =>array(
            'es'=> 'Pre reserva',
            'en'=>'Pre book',
            'pt'=>'Janeiro'
            ),
        'book_now' =>array(
            'es'=> 'Reservar',
            'en'=>'Book Now',
            'pt'=>'Janeiro'
            ),
        'contact_us' =>array(
            'es'=> 'Contactenos',
            'en'=>'Contact Us',
            'pt'=>'Contactenos'
            ),
        'not_availability' =>array(
            'es'=> 'No disponible',
            'en'=>'Not available',
            'pt'=>'No disponible'
            )
        );
    return $words[$word][$lang];
}
function urls($url)
{
    $data = array(
        'url_book' => "http://domain.com/",
        'url_alternative' => 'http://domain.com/',
        'url_contact' => 'http://domain.com/',
    );
    return $data[$url];
}
function languageSmall($lan)
{
    $newLang = substr($lan, 0, 2);
    if ($newLang == "es" or $newLang=="en" or $newLang=="pt")
    {
        return $newLang;
    } else {
        return "es";
    }
}
function yearToOption($year = 0)
{
    $option = " ";
    $now = date("Y");
    if ($year == 0 or $now == $year )
    {
        $year = $now;
    }
    $i = $now + 4;
    while ( $i > $now )
    {
        if($now == $year)
            $option .= '<option value="'.$now.'" selected>'.$now.'</option>';
        else
            $option .= '<option value="'.$now.'" >'.$now.'</option>';
        $now ++;
    }
    return $option;
}

function monthToOption($pLang,$month=0)
{
    if ($month == 0)
    {
        $month = date("n");
    }

    $lang = languageSmall($pLang);
    $option = "";
    for ($i=1; $i < 13; $i++)
    {
        if( $i == $month)
            $option .= '<option value="'.$i.'" selected>'.months($i,$lang) .'</option>';
        else
            $option .= '<option value="'.$i.'" >'.months($i,$lang).'</option>';
    }
    return $option;
}

function incaTrailToOption($pLang,$it=0)
{
    $lang = languageSmall($pLang);
    $option = "";
    for ($i=1; $i < 3; $i++)
    {
        if( $i == $it)
            $option .= '<option value="'.$i.'" selected>'.incatrail($i,$lang) .'</option>';
        else
            $option .= '<option value="'.$i.'" >'.incatrail($i,$lang).'</option>';
    }
    return $option;
}
function language_code($lan)
{
    $newLang = substr($lan, 0, 2);
    if ($newLang == "es" or $newLang=="en" or $newLang=="pt")
    {
        return $newLang;
    } else {
        return "en";
    }
}
function availabilityCalendarDraw($availability,$month,$year,$lang="en")
{
    // Get config information
    $menssage_february = "Inca trail";
    $url_alternative = "http://machupicchu.gob.pe";
    $url_book = "http://machupicchu.gob.pe";
    $url_contact = "http://machupicchu.gob.pe";

    $lang = language_code($lang);
    $calendar = ' ';
    if ($month == 2)
    {
        $calendar .='<div class="it-mensaje">'.$menssage_february.'</div>';
    }
    $calendar .= '<table cellpadding="0" cellspacing="0" id="it-availability">';
    $calendar .= '<tr  bgcolor="#666666" valign="middle">
            <td colspan="7"><div class="it-title">'.months($month,$lang).' '.$year.'</div></td>
        </tr>
        <tr  bgcolor="#FFFFFF">';
    for ($i=1; $i < 8; $i++) {
        $calendar .= '<td><div class="it-day-name">'.days($i,$lang).'</div></td>';
    }
    $maxday = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $timestamp = mktime(0,0,0,$month,1,$year);
    $thismonth = getdate ($timestamp);
    $startday = $thismonth['wday'];
    for ($i=0; $i<($maxday+$startday); $i++) {
        if(($i % 7) == 0 )
        {
            $calendar .= "<tr>";
        }
        if($i < $startday)
        {
            $calendar .= "<td> </td>";
        }
        else
        {
            $day = $i - $startday + 1;

            $alternative = $url_alternative.'?dia='.$day.'&mes='.$month.'&anio='.$year;
            $book = $url_book.'?dia='.$day.'&mes='.$month.'&anio='.$year;
            $contact = $url_contact . '?dia='.$day.'&mes='.$month.'&anio='.$year;
            switch ($availability[$day]) {
                case 'X':
                // Redirigir al formulario de t alter
                    $calendar .= '<td><div class="it-celda">
                            <div class="it-day">'.$day.'</div>
                            <div class="it-day-content"><a href="'.$alternative.'" title="'.words("not_availability",$lang).'">
                            <div class="it-number">0</div>
                            <div class="it-link it-icon it-icon-remove">'.words("not_availability",$lang).'</div>
                            </a>';
                    break;
                case '-':
                    $calendar .= '<td><div class="it-celda">
                            <div class="it-day">'.$day.'</div>
                            <div class="it-day-content">
                            <div class="it-number">0</div>';
                    break;
                case '0':
                    // Redirigir al formulario de t alter
                    $calendar .= '<td><div class="it-celda">
                            <div class="it-day">'.$day.'</div>
                            <div class="it-day-content"><a href="'.$contact.'" title="'.words("contact_us",$lang).'">
                            <div class="it-number">0</div>
                            <div class="it-link it-icon it-icon-ok">'.words("contact_us",$lang).'</div>
                            </a>';
                    break;
                case '200':
                    $calendar .= '<td><div class="it-celda it-celda-available">
                            <div class="it-day">'.$day.'</div>
                            <div class="it-day-content"><a href="'.$alternative.'" title="'.words("pre_book",$lang).'">
                            <div class="it-number">'.$availability[$day].'</div>
                            <div class="it-link it-icon it-icon-ok">'.words("pre_book",$lang).'</div>
                            </a>';
                    break;
                default:
                    $calendar .= '<td><div class="it-celda it-celda-available">
                            <div class="it-day">'.$day.'</div>
                            <div class="it-day-content"><a href="'.$book.'" title="'.words("book_now",$lang).'">
                            <div class="it-number">'.$availability[$day].'</div>
                            <div class="it-link it-icon it-icon-ok">'.words("book_now",$lang).'</div>
                            </a>';
                    break;
            }

            $calendar .= '</div>
                        </td>';
        }
        if(($i % 7) == 6 )
        {
            $calendar .= "</tr>";
        }
    }
    $calendar .= "</table>";
    return $calendar;
}
?>