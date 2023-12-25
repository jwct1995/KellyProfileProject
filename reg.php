<html>
<head>

<?php 
include "db.php";



    $fType=5;
    $uname=" ";
    if(isset($_POST["regsbtn"]))
    {
        $id=DateTimeForId();
        $uname=$_POST["regemail"];




        $query="SELECT * FROM `tbluserloginacc` WHERE `UserName`='".$_POST["regemail"]."'";	
        $sql=mysqli_query($mysqli,$query);
        $row = mysqli_fetch_array($sql, MYSQLI_BOTH);
        $result = mysqli_num_rows($sql);
        if($result==1)
            $fType=3;
        else
        {
            $query="INSERT INTO `tbluserloginacc`(`UserId`, `UserName`, `UserPsw`, `UserFname`, `LastLogin`, `UserPhoneNumber`) VALUES ('U".$id."','".$_POST["regemail"]."','".$_POST["regpassword"]."','".$_POST["regfname"]."',' ','".$_POST["regphone"]."')";
            $result=mysqli_query($mysqli,$query);
            if($result==true)
                $fType=2;
            else
                $fType=4;
        }
    }
    if(isset($_POST["logsbtn"]))
    {
        $query="SELECT * FROM `tbluserloginacc` WHERE `UserName`='".$_POST["logemail"]."' and `UserPsw`='".$_POST["logpassword"]."'";	
        $sql=mysqli_query($mysqli,$query);
        $row = mysqli_fetch_array($sql, MYSQLI_BOTH);
        $result = mysqli_num_rows($sql);
        if($result==1)
        {
            $fType=6;
            /*$row["UserId"];
            $row["UserName"];
            $row["UserFname"];
            $row["UserPhoneNumber"];
            $row["LastLogin"];*/

            $query="UPDATE `tbluserloginacc` SET `LastLogin`='".DateTime()."' WHERE `UserId`='".$row["UserId"]."'";	
            $sql=mysqli_query($mysqli,$query);
        }
        else
            $fType=7;


    }
    



/////////////////////////////////////////////////////////
    function DateTimeForId()
    {
        $t = microtime(true);
        $micro = sprintf("%06d",($t - floor($t)) * 1000000);
        $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
        return $d->format("YmdHisu"); 	
    }
    function DateTime()
    {
        $t = microtime(true);
        $micro = sprintf("%06d",($t - floor($t)) * 1000000);
        $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
        return $d->format("Y-m-d~H:i:s.u"); 	
    }
        

?>



<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js" charset="utf-8"></script>
<script>

var fType=<?php echo $fType;?>;
var uname="<?php echo $uname;?>";

window.onload = function exampleFunction()
{
    

    if(fType==1)
        $("#regTable").css("display","unset");
    if(fType==2 || fType==3 || fType==4 || fType==7)
    {
        $("#regStatus").css("display","unset");

        if(fType==2)
            $("#regStatus").html("Your ID \""+uname+"\" is register Success.");
        if(fType==3)
            $("#regStatus").html("Register Fail .\nYour ID \""+uname+"\" is registed by other user.");
        if(fType==4)
            $("#regStatus").html("Register Fail some other error.");
        if(fType==7)
            $("#regStatus").html("Login Fail.");
    }
        
    if(fType==5)
        $("#logTable").css("display","unset");
    
    if(fType==6)
        $("#proTable").css("display","unset");
        
    <?php 
    if($fType==6)
    {
    ?>
        $("[name='proid']").val("<?php echo$row["UserId"]; ?>");
        $("[name='proemail']").val("<?php echo$row["UserName"]; ?>");
        $("[name='profname']").val("<?php echo$row["UserFname"]; ?>");
        $("[name='prophone']").val("<?php echo$row["UserPhoneNumber"]; ?>");
        $("[name='prologin']").val("<?php echo$row["LastLogin"]; ?>");
    <?php
    }
    ?>
            


    $("[name='regsbtn']").attr("disabled", true);
    $("[name='logsbtn']").attr("disabled", true);
}

$( document ).ready(function()
{
    $(":input").on("keyup change", function(e) 
    {
        if($("[name='regemail']").val() && $("[name='regpassword']").val()==$("[name='regcpassword']").val()&&$("[name='regfname']").val() &&$("[name='regphone']").val() )
            $("[name='regsbtn']").attr("disabled", false);
        else
            $("[name='regsbtn']").attr("disabled", true);
    });

    $(":input").on("keyup change", function(e) 
    {
        if($("[name='logemail']").val() && $("[name='logpassword']").val())
            $("[name='logsbtn']").attr("disabled", false);
        else
            $("[name='logsbtn']").attr("disabled", true);
    });

    $("body").on("click", "[name='menubtn']", function()
    {
        $("#logTable , #regTable , #proTable , #regStatus" ).css("display","none");

        var eleID=$(this).attr("id");

        if(eleID=="menuregbtn")
            $("#regTable").css("display","unset");
        else if(eleID=="menulogbtn")
            $("#logTable").css("display","unset");
    });
});

</script>
</head>
<body>
    <div>
        <button id="menuregbtn" name="menubtn" >Register</button>
        <button id="menulogbtn" name="menubtn" >Login Profile</button>
    </div>
<center>

<form action="reg.php" method="post" id="logTable" style="display: none;">
    <table>
    <tr>
            <td colspan="2" align="center">Login Page</td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="logemail"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="logpassword"></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="logsbtn">
                <input type="reset" name="logrbtn">
            </td>
        </tr>
    </table>
</form>

<form action="reg.php" method="post" id="regTable" style="display: none;">
    <table>
        <tr>
            <td colspan="2" align="center">Register Page</td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="regemail"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="regpassword"></td>
        </tr>
        <tr>
            <td>Confirm Password</td>
            <td><input type="password" name="regcpassword"></td>
        </tr>
        <tr>
            <td>Full Name</td>
            <td><input type="text" name="regfname"></td>
        </tr>""
        <tr>
            <td>Phone Number</td>
            <td><input type="text" name="regphone"></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="regsbtn">
                <input type="reset" name="regrbtn">
            </td>
        </tr>
    </table>
</form>

<div id="regStatus"></div>

<form id="proTable" style="display: none;">
    <table>
        <tr>
            <td colspan="2" align="center">User Profile</td>
        </tr>
        <tr>
            <td>uid</td>
            <td><input type="text" name="proid" disabled></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="proemail" disabled></td>
        </tr>
        <tr>
            <td>Full Name</td>
            <td><input type="text" name="profname" disabled></td>
        </tr>""
        <tr>
            <td>Phone Number</td>
            <td><input type="text" name="prophone" disabled></td>
        </tr>
        <tr>
            <td>Last Login</td>
            <td><input type="text" name="prologin" disabled></td>
        </tr>
    </table>
</form>


</center>
</body>
</html>



