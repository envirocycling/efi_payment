<?php

function dd($value) {
	die(var_dump($value));
}

function grade($_grade) {

	$grade = trim(str_replace('LCLC', 'LC', strtoupper($_grade)));

	if ($grade == 'LCMW' ||
		$grade == 'MW' ||
		$grade == 'MW1' ||
		$grade == 'MW2' ||
		$grade == 'MW3' ||
		$grade == 'MW_PPQ' ||
		$grade == 'MW_PPQ1' ||
		$grade == 'MW_PPQ2' ||
		$grade == 'MW_PC' ||
		$grade == 'MW_CIG' ||
		$grade == 'MW_S' ||
		$grade == 'MW_P' ||
		$grade == 'LCMW1' ||
		$grade == 'LCMW2' ||
		$grade == 'LCMW3' ||
		$grade == 'LCMW_PPQ' ||
		$grade == 'LCMW_PPQ1' ||
		$grade == 'LCMW_PPQ2' ||
		$grade == 'LCMW_PC' ||
		$grade == 'LCMW_CIG' ||
		$grade == 'LCMW_S' ||
		$grade == 'CT' ||
		$grade == 'CORETUBE' ||
		$grade == 'CT MW' ||
		$grade == 'CT M.WASTE' ||
		$grade == 'CORETUBE M.WASTE' ||
		$grade == 'M.WASTE' ||
		$grade == 'LCMW_P') {

		return 'LCMW';

	} else if ($grade == 'ONP' ||
		$grade == 'ONP_B' ||
		$grade == 'NPB' ||
		$grade == 'ONP_DE' ||
		$grade == 'OIN' ||
		$grade == 'LCONP' ||
		$grade == 'LCONP_B' ||
		$grade == 'LCNPB' ||
		$grade == 'LCONP_DE' ||
		$grade == 'LCOIN' ||
		$grade == 'LCONP_GUMS/STICKIES' ||
		$grade == 'ONP_GUMS/STICKIES') {

		return 'LCONP';

	} else if ($grade == 'LCWL' ||
		$grade == 'WL' ||
		$grade == 'WL_S' ||
		$grade == 'WL_B' ||
		$grade == 'WL_CBS' ||
		$grade == 'WL_BOOKS' ||
		$grade == 'WL_GW' ||
		$grade == 'WL_GUMS/STICKIES' ||
		$grade == 'LCWL_GW' ||
		$grade == 'LCWL_GUMS/STICKIES' ||
		$grade == 'LCWL_BOOKS' ||
		$grade == 'LCWL_CBS' ||
		$grade == 'LCWL_B' ||
		$grade == 'LCWL_S') {

		return 'LCWL';

	} else if ($grade == 'LCCBS' ||
		$grade == 'LCCBS_B' ||
		$grade == 'CBS' ||
		$grade == 'CBS_B') {

		return 'LCCBS';

	} else if ($grade == 'LCOCC' ||
		$grade == 'LCOCC_TRIMMINGS' ||
		$grade == 'OCC' ||
		$grade == 'OCC_TRIMMINGS') {

		return 'LCOCC';

	} else if ($grade == 'LCCB' ||
		$grade == 'LCCB_A' ||
		$grade == 'LCCB_B' ||
		$grade == 'CB_A' ||
		$grade == 'CB_B' ||
		$grade == 'CHIPBOARD') {

		return 'LCCB';

	} else {
		return 'OTHERS';
	}
}

function calcWeeks($from, $to) {
	$_from = date("W", strtotime($from));
	$_to = date("W", strtotime($to));

	return ceil($_to - $_from);
}

function loadTargets($payloads = array(), $grades) {

	$data = array();
	$targets = array();

	if (count($payloads) > 0) {
		foreach ($payloads as $value) {
			$targets[$value->wp_grade] = $value->target;
		}
	}

	foreach ($grades as $grade) {
		if (array_key_exists($grade, $targets)) {
			$data[$grade] = $targets[$grade];
		} else {
			$data[$grade] = 0;
		}
	}

	return $data;
}

function loadGrades($payloads = array()) {

	$data = array();

	if (count($payloads) > 0) {
		foreach ($payloads as $value) {
			$data[] = $value->major_class;
		}
	}

	$data[] = 'OTHERS';

	return $data;
}

function loadActuals($payloads = array(), $grades) {

	$actuals = array();

	foreach ($grades as $grade) {
		$actuals[$grade] = 0;
	}

	if (count($payloads) > 0) {

		foreach ($payloads as $value) {

			$actual = (int) $value->weight;
			$wp = trim($value->wp_grade);

			if ($wp) {
				if ($actual) {
					$actuals[grade($wp)] += round($actual / 1000, 3);
				} else {
					$actuals[grade($value->wp_grade)] = 0;
				}
			}

		}

	}

	return $actuals;
}

function loadActualsTipco($payloads = array(), $grades) {

	$actuals = array();

	foreach ($grades as $grade) {
		$actuals['tipco'][$grade] = 0;
		$actuals['fsi'][$grade] = 0;
	}

	if (count($payloads) > 0) {

		foreach ($payloads as $value) {

			$actual = (int) $value->weight;
			$dt = trim(strtoupper($value->delivered_to));
			$wp = grade($value->wp_grade);

			if ($wp) {

				if ($wp == 'LCMW') {

					if ($dt == 'FSI') {
						$actuals['fsi'][$wp] += round($actual / 1000, 3);
					} else {
						$actuals['tipco'][$wp] += round($actual / 1000, 3);
					}

				} else {

					$actuals['tipco'][$wp] += round($actual / 1000, 3);

				}

			}

		}

	}

	return $actuals;
}

function loadBranches() {

	$data = array();
	$branches = getActualBranches();

	foreach ($branches as $branch) {
		if ($branch->branch) {
			$data[] = $branch->branch;
		}
	}

	return $data;

}

function loadClientSalesBranches() {

	$data = array();
	$branches = getClientSalesBranches();

	foreach ($branches as $branch) {
		if ($branch->branch) {
			$data[] = $branch->branch;
		}
	}

	return $data;

}

function loadDates($dates = array(), $wp_grades) {

	$data = array();

	foreach ($dates as $date) {
		foreach ($wp_grades as $grade) {
			$data[$date->date][$grade] = 0;
		}
	}

	return $data;
}

function loadPerDate($dates, $grades, $payloads) {

	$withDates = loadDates($dates, $grades);

	if (count($payloads) > 0) {

		foreach ($payloads as $data) {

			$wp = grade($data->wp_grade);
			$weight = (int) $data->weight;
			$date = $data->date;

			if ($wp) {
				$withDates[$date][$wp] += round($weight / 1000, 3);
			}
		}
	}

	return $withDates;

}

function loadReceiptsAll($payloads = array(), $grades) {

	$receipts = array();

	foreach ($grades as $grade) {
		$receipts[$grade] = 0;
	}

	if (count($payloads) > 0) {

		foreach ($payloads as $value) {

			$weight = (int) $value->weight;
			$wp = grade($value->wp_grade);

			if ($wp) {

				$receipts[$wp] += round($weight / 1000, 3);

			}

		}

	}

	return $receipts;
}

function calcTargetAverage($target) {

	global $number_of_days;

	return round($target / $number_of_days);
}

function calcTotalTargetAverage($actuals, $wp_grades) {

	global $number_of_days;
	$total = 0;

	foreach ($wp_grades as $grade) {
		$total += round($actuals[$grade] / $number_of_days);
	}

	return $total;
}

function calcAverageSalesDaily($actual) {

	global $operational_day;

	return round($actual / $operational_day);
}

function calcTotalAverageSalesDaily($actuals, $wp_grades) {

	global $operational_day;
	$total = 0;

	foreach ($wp_grades as $grade) {
		$total += round($actuals[$grade] / $operational_day);
	}

	return $total;
}

function calcVarianceTargetActual($target, $actual) {

	global $operational_day, $number_of_days;

	$actual_by_grade = round($actual / $operational_day);
	$target_by_grade = round($target / $number_of_days);

	return round($actual_by_grade - $target_by_grade);
}

function calcTotalVarianceTargetActual($targets, $actuals, $wp_grades) {

	global $operational_day, $number_of_days;
	$total = 0;

	foreach ($wp_grades as $grade) {
		$actual_by_grade = round($actuals[$grade] / $operational_day);
		$target_by_grade = round($targets[$grade] / $number_of_days);

		$total += round($actual_by_grade - $target_by_grade);
	}

	return $total;
}

function calcProjectedMt($actual) {

	global $operational_day, $number_of_days;

	return round(($actual / $operational_day) * $number_of_days);
}

function calcTotalProjectedMt($actuals, $wp_grades) {

	global $operational_day, $number_of_days;
	$total = 0;

	foreach ($wp_grades as $grade) {
		$total += round(($actuals[$grade] / $operational_day) * $number_of_days);
	}

	return $total;
}

function calcProjectedPerc($actual, $target) {

	global $operational_day, $number_of_days;

	$projected = 0;

	if ($actual && $target && $operational_day) {
		$projected = round(((($actual / $operational_day) * $number_of_days) / $target) * 100);
	}

	return "{$projected} %";

}

function calcStanding($actual, $target) {

	$standing = 0;

	if ($actual && $target) {
		$standing = round((($actual / $target) * 100));
	}

	return "{$standing} %";
}

function calcTotalStanding($actuals, $targets, $grades) {

	$total_actual = 0;
	$total_target = 0;
	$standing = 0;

	foreach ($grades as $grade) {
		if ($grade == 'LCMW') {
			$total_actual += ($actuals['tipco'][$grade] + $actuals['fsi'][$grade]);
			$total_target += $targets[$grade];
		} else {
			$total_actual += $actuals['tipco'][$grade];
			$total_target += $targets[$grade];
		}
	}

	if ($total_actual && $total_target) {
		$standing = round(($total_actual / $total_target) * 100);
	}

	return "{$standing} %";
}

function calcTotal($payloads, $wp_grades) {

	$total = 0;

	foreach ($wp_grades as $grade) {
		$total += $payloads[$grade];
	}

	return round($total);
}

function calcTotalPerDate($outgoings, $date, $grades) {

	$total = 0;

	foreach ($grades as $grade) {
		$total += $outgoings[$date][$grade];
	}

	return $total;
}

function calcTotalPerBranchPerGrade($_grade, $branches, $wp_grades) {

	$total = array();

	foreach ($wp_grades as $grade) {
		$total[$grade] = 0;
	}

	foreach ($branches as $branch) {

		$actual_branch = loadActuals(getActualByBranch($branch), $wp_grades);

		foreach ($wp_grades as $grade) {
			$total[$grade] += $actual_branch[$grade];
		}
	}

	return $total[$_grade];
}

function calcTotalClientSalesPerBranchPerGrade($_grade, $branches, $wp_grades) {

	$total = array();

	foreach ($wp_grades as $grade) {
		$total[$grade] = 0;
	}

	foreach ($branches as $branch) {

		$actual_branch = loadActuals(getClientSalesByBranch($branch), $wp_grades);

		foreach ($wp_grades as $grade) {
			$total[$grade] += $actual_branch[$grade];
		}
	}

	return $total[$_grade];
}

function calcTotalPerDatePerGrade($_grade, $payloads, $dates, $grades) {

	$total = array();

	foreach ($grades as $grade) {
		$total[$grade] = 0;
	}

	foreach ($dates as $date) {

		foreach ($grades as $grade) {

			if (array_key_exists($grade, $payloads[$date->date])) {
				$total[$grade] += $payloads[$date->date][$grade];
			}

		}
	}

	return $total[$_grade];
}

?>