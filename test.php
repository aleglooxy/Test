<?php
// language stuff
$lang =  'br';
$laNG =  'pt-BR';
$la_NG = 'pt_BR';

$sentences = array(
	'join-team' => 'Join our team now!',
	'lbl-name' => 'Nome completo',
	'ph-name' => 'Michael Ross',
	'lbl-age' => 'Idade',
	'ph-age' => '23',
	'lbl-mail' => 'E-mail',
	'ph-mail' => 'michael@e-mail.com',
	'lbl-skype' => 'Skype',
	'ph-skype' => 'michael.ross',
	'ph-continue' => 'Continuar',
	'best-deal' => 'O Melhor Deal',
	'best-deal-2' => '40% do profit para começar.<br />50% acima de 20k de lucro.',
	'ind-lessons' => 'Aulas Individuais',
	'ind-lessons-2' => 'Duas aulas quando você começar. Uma aula a cada 100 MTTs jogados.',
	'hlvl-coaching' => 'Coaching de Alto Nível',
	'hlvl-coaching-2' => 'Um time de coaches qualificados a sua disposição.',
	'ww-look-for' => 'O que estamos procurando',
	'requirements' => 'Nós precisamos de pessoas motivadas que sejam capazes de satisfazer estes requerimentos:',
	'requirement-1' => '1500 MTTs com lucro',
	'requirement-2' => 'Disponibilidade para jogar 300 MTTs por mês',
	'requirement-3' => 'Uma referência qualificada',
	'requirement-4' => 'Habilidade de usar o HM ou o PT',
	'statement-ageta' => '“O WiseGrinder me guiou passo a passo no mundo do poker ajudando a tornar o meu sonho em realidade.”',
	'win-ageta' => 'mais de 35k ganhos em MTT no último ano',
	'statement-vietti' => '“Graças ao WiseGrinder eu fui capaz de melhorar as minhas habilidades no poker bem rapidamente.
							<br />Eles permitiram que eu alcançasse ótimos resultados em um tempo relativamente curto.”',
	'win-vietti' => 'mais de 21k ganhos em MTT nos últimos 3 meses',
	'copyright' => 'All rights reserved - Black Wizard Limited',
	'complete' => 'Complete o formulário abaixo e prepare-se para fazer parte do nosso time!',
	'lbl-ps-nickname' => 'Nick PokerStars',
	'ph-nickname' => 'mike831',
	'lbl-references' => 'Referências',
	'ph-references' => 'Paulo da Silva, João Augusto',
	'lbl-ft-nickname' => 'Nick FullTilt',
	'lbl-english' => 'Nível do seu Inglês',
	'ph-english' => 'o quão bem você fala inglês?',
	'lbl-888-nickname' => 'Nick 888',
	'lbl-about' => 'Como você ficou sabendo da gente?',
	'ph-about' => 'forum? banners? notícias?',
	'lbl-other-nickname' => 'Outros sites de poker',
	'lbl-other-nickname-small' => '(incluir o nick)',
	'ph-other-nickname' => 'partypoker: mike381',
	'lbl-history' => 'Envie o seu histórico de mãos',
	'lbl-history-small' => '(docum .txt)',
	'ph-history' => 'clique aqui para adicionar',
	'ph-send' => 'Enviar a sua Inscrição',
	'thank-you' => 'Obrigado por se inscrever',
	'thank-you2' => 'Você receberá um e-mail de confirmação nas próximas 48 horas.',
	'wrong-mail' => 'O e-mail não é válido!',
);

// settings
$thispage = 'http://' . $lang . '.wisegrinder.com';
$goto_page = 1;

// Form data processing
if (!empty($_POST)) {
	
	// FORM 1
	if (isset($_POST['wise_cell_submit'])) {
		$message = '';
		
		if (isset($_POST['wise_full-name'])) {
			$message .= '<br />Full Name:<br />' . $_POST['wise_full-name'] . '<br /><br />';
			
			if (isset($_POST['wise_age'])) {
				$message .= '<br />Age:<br />' . $_POST['wise_age'] . '<br /><br />';
				
				if ( isset($_POST['wise_email']) and filter_var($_POST['wise_email'], FILTER_VALIDATE_EMAIL) ) {
					$message .= '<br />E-mail:<br />' . $_POST['wise_email'] . '<br /><br />';
					
					if (isset($_POST['wise_skype'])) {
						$message .= '<br />Skype:<br />' . $_POST['wise_skype'] . '<br /><br />';
						
						// All OK, go to form 2
						$goto_page = 2;
					}
					else {
						$error = 'error skype';
					}
				}
				else {
					$wrong_mail = TRUE;
				}
			}
			else {
				$error = 'error age';
			}
		}
		else {
			$error = 'error name';
		}
	}
	
	// FORM 2
	if (isset($_POST['wise_pc_submit'])) {
		$form_1 = unserialize(base64_decode($_POST['wise_form_1']));
		
		if (is_array($form_1) and count($form_1)) {
			$message = $form_1['message'];
			// Adding other form values
			if (isset($_POST['wise_ps-nickname'])) {
				$message .= '<br />PokerStars nickname:<br />' . $_POST['wise_ps-nickname'] . '<br /><br />';
			}
			
			if (isset($_POST['wise_ft-nickname'])) {
				$message .= '<br />FullTilt nickname:<br />' . $_POST['wise_ft-nickname'] . '<br /><br />';
			}
			
			if (isset($_POST['wise_888-nickname'])) {
				$message .= '<br />888 nickname:<br />' . $_POST['wise_888-nickname'] . '<br /><br />';
			}
			
			if (isset($_POST['wise_other-nickname'])) {
				$message .= '<br />Other poker sites:<br />' . $_POST['wise_other-nickname'] . '<br /><br />';
			}
			
			if (isset($_POST['wise_references'])) {
				$message .= '<br />References:<br />' . $_POST['wise_references'] . '<br /><br />';
			}
			
			if (isset($_POST['wise_english'])) {
				$message .= '<br />English knowledge:<br />' . $_POST['wise_english'] . '<br /><br />';
			}
			
			if (isset($_POST['wise_about'])) {
				$message .= '<br />How did you know about us?<br />' . $_POST['wise_about'] . '<br /><br />';
			}
			
			// manage history file
			if (isset($_FILES['wise_history'])) {
				if ($_FILES['wise_history']['type'] == 'text/plain') {
					$history = $_FILES['wise_history'];
				}
			}

			//send emails
			$error_mail = !send_admin_mail($message, $history);
				
			// All OK, go to thanks page
			$goto_page = 3;
		}
		else {
			$error = 'error form 1';
		}
	}
}
?>
<!DOCTYPE HTML>
<html lang="<?php echo $laNG; ?>" prefix="og: http://ogp.me/ns#">
<head>
	<!-- Meta Tags -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Title -->
	<title>WiseGrinder - The Staking Adventure - Registration form</title>
	<!-- Mobile Device Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
	
	<!-- The HTML5 Shim for older browsers (mostly older versions of IE). -->
	<!--[if IE]> <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
	
	<link rel="shortcut icon" href="img/favicon.ico">
	<meta name="robots" content="noindex,follow">
	
	<link rel="canonical" href="<?php echo $thispage; ?>">
	<meta property="og:locale" content="<?php echo $la_NG; ?>">
	<meta property="og:type" content="website">
	<meta property="og:title" content="WiseGrinder - The Staking Adventure - Registration form">
	<meta property="og:url" content="http://<?php echo $lang; ?>.wisegrinder.com">
	<meta property="og:site_name" content="WiseGrinder">
	<meta property="og:image" content="img/logo.png">
	
	<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css' media="all">
	<link href="css/style.css" rel='stylesheet' type='text/css' media="all and (min-device-width: 1000px)">
	<link href="css/mobile.css" rel='stylesheet' type='text/css' media="all and (max-device-width: 1000px)">
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	<script type="text/javascript" src="js/detectmobilebrowser.js"></script>
</head>
<body>
	<div class="root"> 
<?php //if ($error) echo "goto " . $goto_page . "===>" . $error;
//if ($error_mail) echo "mail ERROR";

switch ($goto_page) {
	case 3:
		$thanks = TRUE;
	case 2:
?>
		<!-- ###########  PAGE 2  ###########  PAGE 2  ###########  PAGE 2  ###########  PAGE 2  ########### -->
		<!-- ###########  PAGE 3  ###########  PAGE 3  ###########  PAGE 3  ###########  PAGE 3  ########### -->
		<div class="row-container white-bkg" style="<?php echo ($thanks) ? 'display:none;' : ''; ?>">
			<div class="row header2">
				<img class="logo2" src="img/logo.png" alt="WiseGrinder">
				<img class="pc" src="img/schermo_shadow.png" alt="WiseGrinder">
			</div>
		</div>
		
		<div class="row-container blue-bkg" style="<?php echo ($thanks) ? 'display:none;' : ''; ?>">
			<div class="row">
				<div class="complete">
		<?php echo $sentences['complete']; ?>
				</div>
			</div>
		</div>
		
		<div class="row-container white-bkg">
			<div class="row">
				<div class="pc-form" style="<?php echo ($thanks) ? 'display:none;' : ''; ?>">
					<form name="wise_pc-form" id="wise_pc-form" action="<?php echo $thispage; ?>" method="post" 
						  enctype="multipart/form-data">
						<input type="hidden" name="wise_form_1" 
							   value="<?php echo base64_encode(serialize(array('message' => $message))); ?>">
						
						<div class="blue form-inline-div">
							<p><?php echo $sentences['lbl-ps-nickname']; ?></p>
							<input type="text" id="wise_ps-nickname" name="wise_ps-nickname" onclick="select()" 
								   placeholder="<?php echo $sentences['ph-nickname']; ?>">
						</div>
						
						<div class="blue form-inline-div">
							<p><?php echo $sentences['lbl-references']; ?></p>
							<input type="text" id="wise_references" name="wise_references" onclick="select()" 
								   placeholder="<?php echo $sentences['ph-references']; ?>">
						</div>
						
						<div class="blue form-inline-div">
							<p><?php echo $sentences['lbl-ft-nickname']; ?></p>
							<input type="text" id="wise_ft-nickname" name="wise_ft-nickname" onclick="select()" 
								   placeholder="<?php echo $sentences['ph-nickname']; ?>">
						</div>
						
						<div class="blue form-inline-div">
							<p><?php echo $sentences['lbl-english']; ?></p>
							<input type="text" id="wise_english" name="wise_english" onclick="select()" 
								   placeholder="<?php echo $sentences['ph-english']; ?>">
						</div>
						
						<div class="blue form-inline-div">
							<p><?php echo $sentences['lbl-888-nickname']; ?></p>
							<input type="text" id="wise_888-nickname" name="wise_888-nickname" onclick="select()" 
								   placeholder="<?php echo $sentences['ph-nickname']; ?>">
						</div>
						
						<div class="blue form-inline-div">
							<p><?php echo $sentences['lbl-about']; ?></p>
							<input type="text" id="wise_about" name="wise_about" onclick="select()" 
								   placeholder="<?php echo $sentences['ph-about']; ?>">
						</div>
						
						<div class="blue form-inline-div">
							<p>
								<?php echo $sentences['lbl-other-nickname']; ?> 
								<small><?php echo $sentences['lbl-other-nickname-small']; ?></small>
							</p>
							<input type="text" id="wise_other-nickname" name="wise_other-nickname" onclick="select()" 
								   placeholder="<?php echo $sentences['ph-other-nickname']; ?>">
						</div>
						
						<div class="blue form-inline-div" id="div_wise_history">
							<p>
								<?php echo $sentences['lbl-history']; ?>
								<small><?php echo $sentences['lbl-history-small']; ?></small>
							</p>
							<div>
								<input type="text" id="wise_history_mock" placeholder="<?php echo $sentences['ph-history']; ?>">
								<input type="file" id="wise_history" name="wise_history"
									   onchange="document.getElementById('wise_history_mock').value = this.value.substring(12);" />
							</div>
						</div>
						
						<div class="button pc_button">
							<input class="button orange-bkg" id="wise_pc_submit" name="wise_pc_submit" type="submit" 
								   value="<?php echo $sentences['ph-send']; ?>">
						</div>
					</form>
				</div>
				
				<div class="thanks" style="<?php echo ($thanks ? '' : 'display:none;'); ?>">
					<h1 class="green"><?php echo $sentences['thank-you']; ?></h1>
					<h2 class="blue"><?php echo $sentences['thank-you2']; ?></h2>
				</div>
				
				<div class="copyright">
					<p class="small">
						Copyright &#169; <strong class="green">WiseGrinder</strong>, <?php echo $sentences['copyright']; ?>
						<strong style="float: right;">
							<a class="green" href="mailto:mic@wisegrinder.com">contact us</a>
						</strong>
					</p>
				</div>
			</div>
		</div>
<?php 
	break;
	default:
?>
		<!-- ###########  PAGE 1  ###########  PAGE 1  ###########  PAGE 1  ###########  PAGE 1  ########### -->
		<div class="top-pos">
			<img class="logo" src="img/logo.png" alt="WiseGrinder">
			<img class="cell" src="img/cell.png" alt="">
			<img class="join" src="img/join_team.png" alt="<?php echo $sentences['join-team']; ?>">
			<img class="join_mob" src="img/join_mob.png" alt="<?php echo $sentences['join-team']; ?>">
			
			<div class="wrong_mail" style="<?php echo ($wrong_mail ? '' : 'display:none;'); ?>">
				<?php echo $sentences['wrong-mail']; ?>
			</div>
			
			<!-- Cambiato con immagine statica
			<img class="arrow" src="img/freccetta.png" alt="">
			<label class="button orange-bkg" id="join">
				<?php //echo $sentences['join-team']; ?>
			</label>
			-->
			<form name="wise_cell-form" id="wise_cell-form" action="<?php echo $thispage; ?>" method="post" enctype="multipart/form-data">
				<div class="blue">
					<p><?php echo $sentences['lbl-name']; ?></p>
					<input type="text" id="wise_full-name" name="wise_full-name" placeholder="<?php echo $sentences['ph-name']; ?>"
						   onclick="select()" value="<?php echo ($wrong_mail ? $_POST['wise_full-name'] : '') ?>" required>
				</div>
				<div class="blue">
					<p><?php echo $sentences['lbl-age']; ?></p>
					<input type="number" id="wise_age" name="wise_age" placeholder="<?php echo $sentences['ph-age']; ?>"
						   onclick="select()" value="<?php echo ($wrong_mail ? $_POST['wise_age'] : '') ?>" required>
				</div>
				<div class="blue">
					<p><?php echo $sentences['lbl-mail']; ?></p>
					<input type="email" id="wise_email" name="wise_email" placeholder="<?php echo $sentences['ph-mail']; ?>"
						   onclick="clean_email_input()" class="<?php echo ($wrong_mail ? 'error' : '') ?>" required
						   value="<?php echo ($wrong_mail ? $_POST['wise_email'] : '') ?>">
				</div>
				<div class="blue">
					<p><?php echo $sentences['lbl-skype']; ?></p>
					<input type="text" id="wise_skype" name="wise_skype" placeholder="<?php echo $sentences['ph-skype']; ?>"
						   onclick="select()" value="<?php echo ($wrong_mail ? $_POST['wise_skype'] : '') ?>" required>
				</div>
				<div class="button">
					<input class="button orange-bkg" id="wise_cell_submit" name="wise_cell_submit" type="submit" 
						   value="<?php echo $sentences['ph-continue']; ?>">
				</div>
			</form>
		</div>
		
		
		<div class="header row-container blue-bkg">
			<div class="row">
			</div>
		</div>
		
		
		<div class="row-container white-bkg">
			<div class="row">
				<div class="three-boxes">
					<div class="box3">
						<img class="" src="img/deal_ico.png" alt="<?php echo $sentences['best-deal']; ?>">
						<div>
							<h3 class="blue"><?php echo $sentences['best-deal']; ?></h3>
							<h5><?php echo $sentences['best-deal-2']; ?></h5>
						</div>
					</div>

					<div class="box3">
						<img class="" src="img/lesson_ico.png" alt="<?php echo $sentences['ind-lessons']; ?>">
						<div>
							<h3 class="blue"><?php echo $sentences['ind-lessons']; ?></h3>
							<h5><?php echo $sentences['ind-lessons-2']; ?></h5>
						</div>
					</div>

					<div class="box3">
						<img class="" src="img/coach_ico.png" alt="<?php echo $sentences['hlvl-coaching']; ?>">
						<div>
							<h3 class="blue"><?php echo $sentences['hlvl-coaching']; ?></h3>
							<h5><?php echo $sentences['hlvl-coaching-2']; ?></h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="row-container">
			<div class="row">
				<div class="two-boxes">
					<div class="box2">
						<h2 class="blue"><?php echo $sentences['ww-look-for']; ?></h2>
						<p><?php echo $sentences['requirements']; ?></p>
						<ul>
							<li><?php echo $sentences['requirement-1']; ?></li>
							<li><?php echo $sentences['requirement-2']; ?></li>
							<li><?php echo $sentences['requirement-3']; ?></li>
							<li><?php echo $sentences['requirement-4']; ?></li>
						</ul>
					</div>
				
					<div class="box2" id="pc-box2">
						<img class="" src="img/schermoPC.png" alt="Multi Tabling">
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="row-container white-bkg">
			<div class="row">
				<div class="hor-boxes">
					<div class="testimonial">
						<img class="" src="img/ageta.png" alt="Federico Ageta">
						<p><em><?php echo $sentences['statement-ageta']; ?></em></p>
						<p class="testimonial green">Federico Ageta, Italy</p>
						<p class="small"><?php echo $sentences['win-ageta']; ?></p>
					</div>
					
					<div class="testimonial">
						<img class="" src="img/vietti.png" alt="Alex D'Amore">
						<p><em><?php echo $sentences['statement-vietti']; ?></em></p>
						<p class="testimonial green">Angelo Vietti, Italy</p>
						<p class="small"><?php echo $sentences['win-vietti']; ?></p>
					</div>
				</div>
				
				<div class="copyright">
					<p class="small">
						Copyright &#169; <strong class="green">WiseGrinder</strong>, <?php echo $sentences['copyright']; ?>
						<strong style="float: right;">
							<a class="green" href="mailto:mic@wisegrinder.com">Contact Us</a> - 
							<a class="green" target="_blank" href="wg_terms.pdf">Terms & Conditions</a>
						</strong>
					</p>
				</div>
			</div>
		</div>
<?php }
?>
		<div class="row-container blue-bkg footer">
			<span id="back-top" style="<?php echo ($thanks) ? 'display:none;' : ''; ?>"></span>
		</div>
	</div>
</body>
</html>

<?php 
function send_admin_mail($form_data, $file = NULL) {	
	$emailBody = $form_data;
	$emailSubject = 'WiseGrinder - Invio form';
	if ( is_array($file) ) { 
		$attachment = file_get_contents($file['tmp_name']);
	}
	$boundary = md5(time());

	$header = "From: WiseGrinder <webmaster@wisegrinder.com>\r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-Type: multipart/mixed;boundary=\"" . $boundary . "\"\r\n";

	$output = "--".$boundary."\r\n";
	if ( isset($attachment) ) { 
		$output .= "Content-Type: text/plain; name=\"history.txt\";\r\n";
		$output .= "Content-Disposition: attachment;\r\n\r\n";
		$output .= $attachment."\r\n\r\n";
		$output .= "--".$boundary."\r\n";
	}
	$output .= "Content-type: text/html; charset=\"utf-8\"\r\n";
	$output .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
	$output .= $emailBody."\r\n\r\n";
	$output .= "--".$boundary."--\r\n\r\n";

	mail('wisegrinderbr@gmail.com', $emailSubject, $output, $header);
	//return mail('mic@wisegrinder.com', $emailSubject, $output, $header);
	return mail('micalux@gmail.com', $emailSubject, $output, $header);
}