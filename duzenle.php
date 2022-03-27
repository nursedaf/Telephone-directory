<?php include 'baglan.php';
session_start();

$sor = $db->prepare("SELECT * FROM rehber WHERE tel_id=:id");
$sor->execute(array(
	'id' => $_GET['tel_id']
));
$cek = $sor->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Düzenle</title>
	<link rel="canonical" href="https://keenthemes.com/metronic" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->
	<!--begin::Layout Themes(used by all pages)-->
	<link href="assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
	<!--end::Layout Themes-->
	<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />

</head>

<body>
	<?php

	if (isset($_POST['update'])) {
		function isValidTelephoneNumber(string $telephone, int $minDigits = 9, int $maxDigits = 14): bool
		{
			if (preg_match('/^[+][0-9]/', $telephone)) {
				$count = 1;
				$telephone = str_replace(['+'], '', $telephone, $count);
			}

			$telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone);

			return isDigits($telephone, $minDigits, $maxDigits);
		}

		function isDigits(string $s, int $minDigits = 9, int $maxDigits = 14): bool
		{
			return preg_match('/^[0-9]{' . $minDigits . ',' . $maxDigits . '}\z/', $s);
		}

		if (isValidTelephoneNumber($_POST['telefon']) == true) {
			$kaydet = $db->prepare("UPDATE rehber SET 
				ad = ?,
				soyad = ?,
				telefon= ?
				WHERE tel_id = ?");

			$insert = $kaydet->execute(array(
				$_POST['ad'],
				$_POST['soyad'],
				$_POST['telefon'],
				$_GET['tel_id']
			));

			if ($insert) {

				Header("Location:index.php?durum=yes");
				exit;
			} else {

				Header("Location:index.php?durum=no");
				exit;
			}
		}else {
			echo "Invalid phone number";
		}
	}
	
	?>
	<div class="container">
		<div class="col-lg-6">
			<!--begin::Card-->
			<div class="card card-custom gutter-b example example-compact">
				<div class="card-header">
					<h3 class="card-title">Kişiyi Düzenle</h3>
					<div class="card-toolbar">
						<div class="example-tools justify-content-center">
							<span class="example-toggle" data-toggle="tooltip" title="" data-original-title="View code"></span>
							<span class="example-copy" data-toggle="tooltip" title="" data-original-title="Copy code"></span>
						</div>
					</div>
				</div>
				<!--begin::Form-->
				<form class="form" action="duzenle.php?tel_id=<?php echo $_GET['tel_id']; ?>" method="POST">
					<div class="card-body">


						<div class="mb-15">
							<div class="form-group row">
								<label class="col-lg-3 col-form-label">Ad:</label>
								<div class="col-lg-6">
									<input type="text" name="ad" required="" class="form-control" placeholder="Ad" value="<?php echo $cek['ad'] ?>">
									<span class="form-text text-muted">Kişi adını girin.</span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-3 col-form-label">Soyad:</label>
								<div class="col-lg-6">
									<input type="text" name="soyad" required="" class="form-control" placeholder="Soyad" value="<?php echo $cek['soyad'] ?>">
									<span class="form-text text-muted">Kişi soyadını girin.</span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-3 col-form-label">Telefon:</label>
								<div class="col-lg-6">
									<input type="text" name="telefon" required="" class="form-control" placeholder="Telefon numarası" value="<?php echo $cek['telefon'] ?>">
									<span class="form-text text-muted">Kişi telefon numarasını girin.</span>
								</div>
							</div>


							
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-lg-3"></div>
								<div class="col-lg-6">
									<button type="submit" name="update" class="btn btn-success mr-2">Değişiklikleri Kaydet</button>
									<button type="reset" class="btn btn-secondary">İptal</button>
								</div>
							</div>
						</div>
				</form>
				<!--end::Form-->
			</div>
			<!--end::Card-->

		</div>
	</div>
</body>

</html>
