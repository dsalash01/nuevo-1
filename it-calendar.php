<?php
error_reporting(0);
//require('../../../wp-blog-header.php');
require_once  '../../../wp-load.php';

function language($lan)
{
    $newLang = substr($lan, 0, 2);
    if ($newLang == "es" or $newLang=="en" or $newLang=="pt")
    {
        return $newLang;
    } else {
        return "en";
    }
}
function availabilityCalendar($availability,$month,$year,$lang="en")
{
    // Get config information
    $menssage_february = get_option('inca_trail_february',"Inca trail");
    $url_alternative = get_option('inca_trail_alternative',"http://machupicchu.gob.pe");
    $url_book = get_option('inca_trail_book',"http://machupicchu.gob.pe");
    $url_contact = get_option('inca_trail_contact',"http://machupicchu.gob.pe");

    $lang = language($lang);
    $calendar = ' ';
    if ($month == 2)
    {
        $calendar .='<div class="it-wrapper-mensaje"><div class="it-mensaje">'.$menssage_february.'</div></div>';
    }
    $calendar .= '<table cellpadding="0" cellspacing="0" id="it-availability">';
    $calendar .= '<tr class="it-month" valign="middle">
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
                case '-1':
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
function availabilityIncaTrail($month, $year, $place)
{
    // 2. Descargar json y decodificar TEXTO
    $dataJson = file_get_contents(API_URL . "?place=".$place."&month=".$month."&year=".$year);
    // 2.1 Decodificar
    $dataArray = json_decode($dataJson);
    return $dataArray;
}
 ?>