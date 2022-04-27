<?php
    /**
	* 每个地区的律师
	**/
	function getLawyerByArea($city=1) {
		if ($city==1) {
			//涉及财产关系
			$result['propertyRelations']['low'] = 2000;
			$result['propertyRelations']['height'] = 12000;
			//不涉及财产关系
			$result['noPropertyRelations']['low'] = 2500;
			$result['noPropertyRelations']['height'] = 3000;
			$result['criminal'] = ['侦查阶段：1500-10000元/件','审查起诉阶段：2000-15000元/件','2500-25000元/件'];
			//伙食补助费
			$result['foodAllowance']['min'] = 12;
			$result['foodAllowance']['max'] = 20;
			//统筹地区上年度职工年平均工资
			$result['AverageMonthlySalary'] = 74906;

		}
		return $result;
	}
?>