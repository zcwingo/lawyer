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

	/**
	 * 工伤赔偿
	 * $pd  0为受伤，1-10为一至十级伤残，11为死亡
	 * $money 本月份工资
	 * $area  所在地区
	 * $data  其它数据，包括工伤康复费、伙食补助费、交通费、食宿费、护理费等费用
	 */
	function WorkerCompensation($pd=0,$money=0,$area=1,$data=[]) {
		$config = getLawyerByArea(1);
		$ams = $config['AverageMonthlySalary'];
		if ($pd==0) {
			//无伤残、非死亡	
			$month = sprintf( "%.1f",$data['day']/30);	//住院天数	转换成月
			$foods = getLawyerByArea(1);	//找出山东伙食补助费 
			$foods = $foods['foodAllowance'];	//伙食费
			//保险医疗费计算   (用户自己填加)		

			$result[0]['title'] = '保险医疗费';
			$result[0]['value'] = $data['ime'];	//用户填加的保险医疗费
			$result[0]['bark'] = '符合工伤保险诊疗项目目录、药品目录、住院服务标准';

			//工伤康复费   (用户自己填加)

			$result[1]['title'] = '工伤康复费';
			$result[1]['value'] = $data['iirf'];
			$result[1]['bark'] = $result['0']['bark'];

			//伙食补助费
			$result[2]['title'] = '伙食补助费';
			$result[2]['value'] = $foods['min']*$data['day'].'-'.$foods['max']*$data['day'];
			$result[2]['bark'] = '统筹地区之外需由医疗机构证明经办机构同意';
			//交通费、食宿费  (用户自己填加)
			$result[3]['title'] = '交通费、食宿费';
			$result[3]['value'] = $data['tep'];
			$result[3]['bark'] = '实报实缴';

			//工资 停工留薪
			$result[4]['title'] = '工资';
			$result[4]['value'] = $money*$month;
			$result[4]['bark'] = '工资';

			//辅助器具费
			$result[5]['title'] = '辅助器具费';
			$result[5]['value'] = $data['aef'];
			$result[5]['bark'] = '经劳动能力鉴定确认配置';

			//护理费
			$result[6]['title'] = '护理费';
			$result[6]['value'] = (100*$data['day']).'-'.(120*$data['day']);
			$result[6]['bark'] = '';
		} elseif ($pd>0&&$pd<=10) {
			$otda = $otms = $otes = $dbf = 0;
			//$pd为商残等级，最高为10张
			if ($pd==1) {
				//一次性伤残补助
				$otda = $money*27;
				//伤残津贴
				$dbf = $money*0.9; 
				//生活护理费
				$lcf = (sprintf( "%.1f",$ams/12)*0.3).'-'.(sprintf( "%.1f",$ams/12)*0.5);
			} elseif ($pd==2) {
				//一次性伤残补助
				$otda = $money*25;
				//伤残津贴
				$dbf = $money*0.85;
				//生活护理费
				$lcf = (sprintf( "%.1f",$ams/12)*0.3).'-'.(sprintf( "%.1f",$ams/12)*0.5);
			} elseif ($pd==3) {
				//一次性伤残补助
				$otda = $money*23;
				//伤残津贴
				$dbf = $money*0.8;
				//生活护理费
				$lcf = (sprintf( "%.1f",$ams/12)*0.3).'-'.(sprintf( "%.1f",$ams/12)*0.5);
			} elseif ($pd==4) {
				//一次性伤残补助
				$otda = $money*21;
				//伤残津贴
				$dbf = $money*0.75;
				//生活护理费
				$lcf = (sprintf( "%.1f",$ams/12)*0.3).'-'.(sprintf( "%.1f",$ams/12)*0.5);
			} elseif ($pd==5) {
				//一次性伤残补助
				$otda = $money*18;
				//伤残津贴
				$dbf = $money*0.7;
				//一次性医疗补助
				$otms = sprintf( "%.1f",$ams/12)*22;
				//一次性就业补助
				$otes = sprintf( "%.1f",$ams/12)*36;

			} elseif ($pd==6) {
				//一次性伤残补助
				$otda = $money*16;
				//伤残津贴
				$dbf = $money*0.6;
				//一次性医疗补助
				$otms = sprintf( "%.1f",$ams/12)*18;
				//一次性就业补助
				$otes = sprintf( "%.1f",$ams/12)*30;
				
			} elseif ($pd==7) {
				//一次性伤残补助
				$otda = $money*13;
				//一次性医疗补助
				$otms = sprintf( "%.1f",$ams/12)*13;
				//一次性就业补助
				$otes = sprintf( "%.1f",$ams/12)*20;
				
			} elseif ($pd==8) {
				//一次性伤残补助
				$otda = $money*11;
				//一次性医疗补助
				$otms = sprintf( "%.1f",$ams/12)*10;
				//一次性就业补助
				$otes = sprintf( "%.1f",$ams/12)*16;
			} elseif ($pd==9) {
				//一次性伤残补助
				$otda = $money*9;
				//一次性医疗补助
				$otms = sprintf( "%.1f",$ams/12)*7;
				//一次性就业补助
				$otes = sprintf( "%.1f",$ams/12)*12;
			} elseif ($pd==10) {
				//一次性伤残补助
				$otda = $money*7;
				//一次性医疗补助
				$otms = sprintf( "%.1f",$ams/12)*4;
				//一次性就业补助
				$otes = sprintf( "%.1f",$ams/12)*8;
			}
			if ($otda>0) {
				$result[0]['title'] = '一次性伤残补助';
				$result[0]['value'] = $otda;
				$result[0]['bark'] = '';
			}
			if ($otms>0) {
				$result[1]['title'] = '一次性医疗补助';
				$result[1]['value'] = $otms;
				$result[1]['bark'] = '';
			}
			if ($otes>0) {
				$result[2]['title'] = '一次性就业补助';
				$result[2]['value'] = $otes;
				$result[2]['bark'] = '';
			}
			if ($dbf>0) {
				$result[3]['title'] = '伤残津贴';
				$result[3]['value'] = $dbf;
				$result[3]['bark'] = '';
			}
			if ($lcf>0) {
				$result[3]['title'] = '生活护理费';
				$result[3]['value'] = $lcf;
				$result[3]['bark'] = '';
			}

		} elseif ($pd==11) {
			//工亡			
			 $sndqgczjmrjkzpsr	= 47412;	//上年度全国城镇居民人均可支配收入

			 //丧葬补助金
			 $funeralAllowance = sprintf( "%.1f",$ams/12);

			 $result[0]['title'] = '丧葬补助金';
			 $result[0]['value'] = $funeralAllowance;
			 $result[0]['bark'] = '';

			 //一次性工亡补助金
			 $result[1]['title'] = '一次性工亡补助金';
			 $result[1]['value'] = 47412*20;	//上年度全国城镇居民人均可支配收入47412
			 $result[1]['bark'] = '';

			 //抚恤金
			 $result[2]['title'] = '抚恤金';
			 $result[2]['value'] = '看下方备注说明';
			 $result[2]['bark'] = '';
		}

		return $result;
	}
	/**
	* 律师费计算器
	* type:1民事案件 2为刑事案件
	**/
	function lawyerFeeCalculator($type=1,$money=0,$city=1) {
		$coin = getLawyerByArea($city);
		if ($type==1) {
			if ($money<=10000) {
				//涉及财产关系
				$result['propertyRelations'] = '2500-12000元';
				//不涉及财产关系
				$result['noPropertyRelations'] = '2500-3000元';
			} elseif ($money<=100000&&$money>10000) {
				$rate[0] = 0.06;
				$rate[1] = 0.09;
				//涉及财产关系
				$ymoney['low'] = ($money-10000)*$rate[0]+$coin['propertyRelations']['low'];
				$ymoney['height'] = ($money-10000)*$rate[1]+$coin['propertyRelations']['height'];
				$result['propertyRelations'] = $ymoney['low'].'-'.$ymoney['height'].'元';
				//不涉及财产关系
				$nmoney['low'] = ($money-10000)*$rate[0]+$coin['nopropertyRelations']['low'];
				$nmoney['height'] = ($money-10000)*$rate[1]+$coin['nopropertyRelations']['height'];
				$result['nopropertyRelations'] = $nmoney['low'].'-'.$nmoney['height'].'元';
			} elseif ($money<=5000000&&$money>100000) {
				$rate[0] = 0.05;
				$rate[1] = 0.06;
				//涉及财产关系
				$ymoney['low'] = ($money-10000)*$rate[0]+$coin['propertyRelations']['low'];
				$ymoney['height'] = ($money-10000)*$rate[1]+$coin['propertyRelations']['height'];
				$result['propertyRelations'] = $ymoney['low'].'-'.$ymoney['height'].'元';
				//不涉及财产关系
				$nmoney['low'] = ($money-10000)*$rate[0]+$coin['nopropertyRelations']['low'];
				$nmoney['height'] = ($money-10000)*$rate[1]+$coin['nopropertyRelations']['height'];
				$result['nopropertyRelations'] = $nmoney['low'].'-'.$nmoney['height'].'元';
			} elseif ($money<=1000000&&$money>500000) {
				$rate[0] = 0.04;
				$rate[1] = 0.05;
				//涉及财产关系
				$ymoney['low'] = ($money-10000)*$rate[0]+$coin['propertyRelations']['low'];
				$ymoney['height'] = ($money-10000)*$rate[1]+$coin['propertyRelations']['height'];
				$result['propertyRelations'] = $ymoney['low'].'-'.$ymoney['height'].'元';
				//不涉及财产关系
				$nmoney['low'] = ($money-10000)*$rate[0]+$coin['nopropertyRelations']['low'];
				$nmoney['height'] = ($money-10000)*$rate[1]+$coin['nopropertyRelations']['height'];
				$result['nopropertyRelations'] = $nmoney['low'].'-'.$nmoney['height'].'元';
			} elseif ($money<=1000000&&$money>5000000) {
				$rate[0] = 0.03;
				$rate[1] = 0.04;
				//涉及财产关系
				$ymoney['low'] = ($money-10000)*$rate[0]+$coin['propertyRelations']['low'];
				$ymoney['height'] = ($money-10000)*$rate[1]+$coin['propertyRelations']['height'];
				$result['propertyRelations'] = $ymoney['low'].'-'.$ymoney['height'].'元';
				//不涉及财产关系
				$nmoney['low'] = ($money-10000)*$rate[0]+$coin['nopropertyRelations']['low'];
				$nmoney['height'] = ($money-10000)*$rate[1]+$coin['nopropertyRelations']['height'];
				$result['nopropertyRelations'] = $nmoney['low'].'-'.$nmoney['height'].'元';
			} elseif ($money>=5000000) {
				$result['propertyRelations'] = '500万元以上部分由律师事务所和委托人协商确定';
				$result['nopropertyRelations'] = '';
			}
		} else {
			$result['propertyRelations'] = $coin['criminal'];
			$result['nopropertyRelations'] = '';
		}
		return $result;
	}
?>