<?php
error_reporting(0);
set_time_limit(600);

//define('KOL_ROOT', str_replace('\\', '/', substr(dirname(__FILE__), 0, -7)));
define('KOL_ROOT', substr(dirname(__FILE__), 0, -strlen('install')));

include_once('header.php');
$step = $_GET['step'];
if($step == 4)  {
	$status = 1;
	echo 'KOL_ROOT : ' .KOL_ROOT;
	echo '<br/><br/>';

	// step 1
	$result = exec('cd '.KOL_ROOT,$output,$status);

	echo 'step 1';
	echo '<br/><br/>';

	echo '$result : ';
	var_dump($result);
	echo '<br/><br/>';

	echo '$status : ';
	var_dump($status);
	echo '<br/><br/>';

	echo '$output : ';
	var_dump($output);
	echo '<br/><br/>';

	// step 2
//	$result = exec('/usr/bin/git fetch --all',$output,$status);
	$result = exec('sudo -u root -S {{ /usr/bin/git fetch --all }} < ~/.sudopass/sudopass.secret',$output,$status);

	echo 'step 2';
	echo '<br/><br/>';

	echo '$result : ';
	var_dump($result);
	echo '<br/><br/>';

	echo '$status : ';
	var_dump($status);
	echo '<br/><br/>';

	echo '$output : ';
	var_dump($output);
	echo '<br/><br/>';

	// step 3
//	$result = exec('/usr/bin/git reset --hard origin/develop',$output,$status);
	$result = exec('sudo -u root -S {{ /usr/bin/git reset --hard origin/develop }} < ~/.sudopass/sudopass.secret',$output,$status);

	echo 'step 3';
	echo '<br/><br/>';

	echo '$result : ';
	var_dump($result);
	echo '<br/><br/>';

	echo '$status : ';
	var_dump($status);
	echo '<br/><br/>';

	echo '$output : ';
	var_dump($output);
	echo '<br/><br/>';

	// step 4
//	$result = exec('rm -r Blog_Web/Runtime',$output,$status);
	$result = exec('sudo -u root -S {{ rm -r Blog_Web/Runtime }} < ~/.sudopass/sudopass.secret',$output,$status);

	echo 'step 4';
	echo '<br/><br/>';

	echo '$result : ';
	var_dump($result);
	echo '<br/><br/>';

	echo '$status : ';
	var_dump($status);
	echo '<br/><br/>';

	echo '$output : ';
	var_dump($output);
	echo '<br/><br/>';

	if ($status == 0){
	     echo '<script type="text/javascript"> alert("发布成功") </script>';
//	    echo
//	    '<script language="JavaScript" type="text/javascript">
//           window.location.href="/mywork/qwechat";
//    	</script>';
	}
// 	Header("Location: index.php");
}

header('Content-Type: text/html; charset=utf-8');
$PHP_SELF = addslashes(htmlspecialchars($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']));

?>

<body>
	<form method="post" action="index.php?step=4">
		<div class="form-actions">
			<button type="submit" class="pull-right btn btn-primary">一键发布（测试环境）</button>
		</div>
	</form>
</body>

<?php include_once('footer.php'); ?>
