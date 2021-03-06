<?php

namespace Middleware;

class Calendar 
{
  public static function get($year = "", $month = "") {
  $holidays = array();
  $hol = array();

  $dbh = \Db::getInstance();

  $dbh->beginTransaction();
  $sql = new \Model\Schedules();
  $sql->order('created_at', 'desc');
  $sth = $dbh->prepare($sql->select());
  $sth->execute($sql->values());

  $dbh->commit();
  
  function repeat($n) {
  	return str_repeat("\t\t<td> </td>\n", $n);
  }

	if(empty($year) && empty($month)) {
		$year = date("Y");
		$month = date("n");
	}

  while ($result = $sth->fetchObject()) {
    if (date("Yn") == date("Yn", strtotime($result->date))) {
      $holidays[] = $result;
    }
  }

	$l_day = date("j", mktime(0, 0, 0, $month + 1, 0, $year));

	$tmp = <<<EOM
<table>
	<caption>{$year}年{$month}月</caption>
	<tr>
		<th class="sun">sun</th>
		<th>mon</th>
		<th class="tue">tue</th>
		<th>wed</th>
		<th>thu</th>
		<th>fri</th>
		<th class="sat">sat</th>
	</tr>\n
EOM;

	$lc = 0;
  $w = date("w");

	for ($i = 1; $i < $l_day + 1; $i++) {
    $hol = array();

    foreach($holidays as $holiday) {
      if ($i == date("d", strtotime($holiday->date))) {
        $hol[] = $holiday->stuff;
		  }
    }

		$week = date("w", mktime(0, 0, 0, $month, $i, $year));

		if ($week == 0) {
			$tmp .= "\t<tr>\n";
			$lc++;
		}

		if ($i == 1) {
			if($week != 0) {
				$tmp .= "\t<tr>\n";
				$lc++;
			}

			$tmp .= repeat($week);
		}

		if ($i == date("j") && $year == date("Y") && $month == date("n") && !empty($hol) && $week == 2) {
      $staff_holiday = array();

      foreach ($hol as $num) {
        $staff_holiday[] = "<span class=\"stuff". $num . "\"></span>";
      }

      $staff_holiday = implode(' ', $staff_holiday);

			$tmp .= "\t\t<td class=\"today tue\">{$i}<br>{$staff_holiday}</td>\n";
    }

		else if ($i == date("j") && $year == date("Y") && $month == date("n") && !empty($hol)) {
      $staff_holiday = array();

      foreach ($hol as $num) {
        $staff_holiday[] = "<span class=\"stuff". $num . "\"></span>";
      }

      $staff_holiday = implode(' ', $staff_holiday);

			$tmp .= "\t\t<td class=\"today\">{$i}<br>{$staff_holiday}</td>\n";
    }

		else if ($i == date("j") && $year == date("Y") && $month == date("n") && $week == 2) {
			$tmp .= "\t\t<td class=\"today tue\">{$i}</td>\n";
    }

		else if (!empty($hol) && $week == 2) {
      $staff_holiday = array();

      foreach ($hol as $num) {
        $staff_holiday[] = "<span class=\"stuff". $num . "\"></span>";
      }

      $staff_holiday = implode(' ', $staff_holiday);

			$tmp .= "\t\t<td class=\"tue\">{$i}<br>{$staff_holiday}</td>\n";
    }

    else if (!empty($hol)) {
      $staff_holiday = array();

      foreach ($hol as $num) {
        $staff_holiday[] = "<span class=\"stuff". $num . "\"></span>";
      }

      $staff_holiday = implode(' ', $staff_holiday);

			$tmp .= "\t\t<td>{$i}<br>{$staff_holiday}</td>\n";
		}

		else if ($week == 2) {
			$tmp .= "\t\t<td class=\"tue\">{$i}</td>\n";
    }

		else if ($i == date("j") && $year == date("Y") && $month == date("n")) {
			$tmp .= "\t\t<td class=\"today\">{$i}</td>\n";
    }

    else {
			$tmp .= "\t\t<td>{$i}</td>\n";
		}

		if ($i == $l_day) {
			$tmp .= repeat(6 - $week);
		}

		if($week == 6) {
			$tmp .= "\t</tr>\n";
		}
	}

	if($lc < 6) {
		$tmp .= "\t<tr>\n";
		$tmp .= repeat(7);
		$tmp .= "\t</tr>\n";
	}

	if($lc == 4) {
		$tmp .= "\t<tr>\n";
		$tmp .= repeat(7);
		$tmp .= "\t</tr>\n";
	}

	$tmp .= "</table>\n";

	return $tmp;
  }
}
