<?php


function thai_date($time){
	$thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
	$thai_month_arr=array(
	"1"=>"ม.ค.",
	"2"=>"ก.พ.",
	"3"=>"มี.ค.",
	"4"=>"เม.ย",
	"5"=>"พ.ค.",
	"6"=>"มิ.ย.",	
	"7"=>"ก.ค.",
	"8"=>"ส.ค.",
	"9"=>"ก.ย.",
	"10"=>"ต.ค.",
	"11"=>"พ.ย.",
	"12"=>"ธ.ค."					
	);
	
	$thai_date_return =	date("j",$time);
	//echo date("n",$time);
	$thai_date_return.=" ".$thai_month_arr[date("n",$time)];
	$thai_date_return.=	" ".substr((date("Y",$time)+543),2);
	return $thai_date_return;
}
?>