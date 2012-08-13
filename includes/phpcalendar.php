<?php
# PHP Calendar (version 2.3), written by Keith Devens
# http://keithdevens.com/software/php_calendar
#  see example at http://keithdevens.com/weblog
# License: http://keithdevens.com/software/license

function spanish_month ($month) {
	switch (intval($month)) {
		case 1: return("Enero");
		case 2: return("Febrero");
		case 3: return("Marzo");
		case 4: return("Abril");
		case 5: return("Mayo");
		case 6: return("Junio");
		case 7: return("Julio");
		case 8: return("Agosto");
		case 9: return("Septiembre");
		case 10: return("Octubre");
		case 11: return("Noviembre");
		case 12: return("Diciembre");
	}
}

function spanish_day ($arr_days) {
	$arr_ret = array();
	foreach ($arr_days as $index=>$value) {
		switch (strtolower($value)) {
			case 'monday':
				$arr_ret[$index] = 'Lunes';
				break;
			case 'tuesday':
				$arr_ret[$index] = 'Martes';
				break;
			case 'wednesday':
				$arr_ret[$index] = 'Mi&eacute;rcoles';
				break;
			case 'thursday':
				$arr_ret[$index] = 'Jueves';
				break;
			case 'friday':
				$arr_ret[$index] = 'Viernes';
				break;
			case 'saturday':
				$arr_ret[$index] = 'S&aacute;bado';
				break;
			case 'sunday':
				$arr_ret[$index] = 'Domingo';
				break;
		}
	}
	return($arr_ret);
}

function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array()){
	$first_of_month = gmmktime(0,0,0,$month,1,$year);
	#remember that mktime will automatically correct if invalid dates are entered
	# for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998
	# this provides a built in "rounding" feature to generate_calendar()
	
	$arr_calendar = array();
	
	$day_names = array(); #generate all the day names according to the current locale
	$arr_days = array();
	for ($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) { #January 4, 1970 was a Sunday
		$arr_days[$n] = $day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name
	}
	$arr_days = spanish_day ($arr_days);
	$arr_calendar[] = $arr_days;
	
	list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
	$weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
	$title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names

	#Begin calendar. Uses a real <caption>. See http://diveintomark.org/archives/2002/07/03
	@list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable
	if($p) $p = '<span class="calendar-prev">'.($pl ? '<a href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>&nbsp;';
	if($n) $n = '&nbsp;<span class="calendar-next">'.($nl ? '<a href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>';
	
	
	
	$calendar = '<table class="calendar">'."\n".
		'<caption class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</caption>\n<tr>";
		
	if($day_name_length){ #if the day names should be shown ($day_name_length > 0)
		#if day_name_length is >3, the full name of the day will be printed
		$arr_days = array();
		foreach ($day_names as $d) {
			$calendar .= '<th abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>';
		}
		$calendar .= "</tr>\n<tr>";
	}
	
	$arr_week = array();
	if ($weekday > 0) {
		$calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days
		for ($i=0;$i<$weekday; $i++) {
			$arr_week[] = '';
		}
	}
	
	for ($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++) {
		if ($weekday == 7) {
			$weekday   = 0; #start a new week
			$arr_calendar[] = $arr_week;
			$arr_week = array();
			$calendar .= "</tr>\n<tr>";
		}
		if(isset($days[$day]) and is_array($days[$day])){
			@list($link, $classes, $content) = $days[$day];
			if(is_null($content))  $content  = $day;
			$calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>').
				($link ? '<a href="'.htmlspecialchars($link).'">'.$content.'</a>' : $content).'</td>';
		}
		else $calendar .= "<td>$day</td>";
		$arr_week[] = $day;
	}
	if ($weekday != 7) {
		$last_arr_week_day = end($arr_week);
		for ($i=$last_arr_week_day+1; $i<=$days_in_month; $i++) {
			$arr_week[] = $i;
		}
		
		while (count($arr_week)<7) {
			$arr_week[] = '';
		}
		
		$arr_calendar[] = $arr_week;
		$calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days
	}
	
	$calendar .= "</tr>\n</table>\n";
	
	return(array('array'=>$arr_calendar, 'string'=>$calendar));
}
?>