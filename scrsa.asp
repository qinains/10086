<script language="javascript" src="/api/other/RSA.js" runat="server"></script> 
<script language="javascript" src="/api/other/BigInt.js" runat="server"></script>
<script language="javascript" src="/api/other/Barrett.js" runat="server"></script>
<script language="javascript" runat="server">
CardPwd=Request.QueryString("CardPwd")
NewKey=String(Request.QueryString("rsakey"))

function getRsaResult(vParam,module_cz) {
 setMaxDigits(130); 
 var key = new RSAKeyPair("10001","",module_cz);
 var result = encryptedString(key,encodeURIComponent(vParam)); 
 return result;
}

var Result = getRsaResult(CardPwd,NewKey);

Response.Write(Result)
</script>