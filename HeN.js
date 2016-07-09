// 计算支付金额
var payfee = process.argv.slice(2);
var discount = payfee < 100 ?  985 : 980;
round(payfee, discount);

//数字 指定位数后 四舍五入  
function round(inputval, discount){
	var discountOther=990;//99折
	var zk=discount;  //折扣
	var yjje="";  //应交金额
	var yjjeOther="";  //应交金额99折
	var yhje="";  //折扣金额
	var zjz=0;
	var zjzOther=0;    
	var hs=0;
	var hsOther=0;
	var zkhs=0;
	//-------------985~99折--------------------------
	zjz=(zk*inputval).toString();//手机支付折扣 980*100
	hs=parseInt(zjz.substr(0,zjz.length-1));
	if(parseInt(zjz.substr(zjz.length-1,zjz.length))>4){//四舍五入
		hs=hs+1;
	}
	//zkhs=inputval*100-hs;
	yjje=(hs/100).toString();
	if(yjje.indexOf(".")!=-1){
		if((yjje.length-yjje.lastIndexOf("."))==2){
			yjje=yjje+"0"
		}
	}else{
		yjje=yjje+".00"
	}
	//----------99折交金额----------------------------------------
	zjzOther=(discountOther*inputval).toString();//其他支付折扣
	hsOther=parseInt(zjzOther.substr(0,zjzOther.length-1));
	if(parseInt(zjzOther.substr(zjzOther.length-1,zjzOther.length))>4){//四舍五入
		hsOther=hsOther+1;
	}
	yjjeOther=(hsOther/100).toString();
	if(yjjeOther.indexOf(".")!=-1){
		if((yjjeOther.length-yjjeOther.lastIndexOf("."))==2){
			yjjeOther=yjjeOther+"0"
		}
	}else{
		yjjeOther=yjjeOther+".00"
	}
	
	console.log(yjje+"A"+yjjeOther);
}