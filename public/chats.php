<?php
	session_start();
	if (!isset($_SESSION['nick'])) {
		header("Location: index.html");
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Chats</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="img/icono.png">
	<link rel="stylesheet" type="text/css" href="css/cssPrincipal.css"/>
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
	<script src="js/jquery-3.2.0.min.js"></script>
	<script>
		$(document).ready(function(){
			$( "#header" ).load('loginHome.html');
		});
	</script>
</head>
<body>
	<div id="header"></div>

	<div class="center-block" id="chat-box">
		<div class="panel panel-default">
			<div class="panel-heading container-fluid">
				<div class="row">
					<div class="col-md-2 col-sm-3 col-xs-5">
						<span class="heading-medium"> Chats </span>
					</div>
					<div class="col-md-8 col-sm-7 col-xs-4"></div>
					<div class="col-md-2 col-sm-2 col-xs-2">
						<div data-toggle="modal" data-target="#nuevoMensajeModal">
							<a role="button" class="btn btn-default" id="nuevo-chat" href="#" data-toggle="tooltip" data-placement="top" title="Nuevo chat">
								<span class="glyphicon glyphicon-plus-sign" id="nuevo-chat-icono"></span>
							</a>
						</div>

						<div id="nuevoMensajeModal" class="modal fade modalsChats container-fluid" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
								    	<button type="button" class="close" data-dismiss="modal">&times;</button>
								    	<h4 class="modal-title">Nuevo mensaje</h4>
								  	</div>
									<div class="modal-body">
										<form class="form-horizontal" method="post" action="newMessage.php">
											<div class="form-group">
                                                <label class="control-label col-sm-3" for="select_destinatary">Para:</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="select_destinatary" name="select_destinatary">
                                                    	<?php
                                                    		$db=@mysqli_connect('localhost', 'root', 'root', 'guaunder');
                                                    		$sql="select distinct g1.us_like as g1Like from matches_guau g1, matches_guau g2 where g1.us_like=g2.us_target and g1.us_target=g2.us_like and g1.us_target='".$_SESSION['nick']."' and g1.us_like <> '".$_SESSION['nick']."'";
                                                    		$consulta=mysqli_query($db,$sql);

                                                    		echo '<option value="" disabled selected>Selecciona el destinatario</option>';
                                                    		while ($matches = mysqli_fetch_assoc($consulta)) {
                                                    			echo "<option value=".$matches['g1Like'].">".$matches['g1Like']."</option>";
                                                    		}
                                                    		@mysqli_close($db);
                                                    	?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="message_content">Mensaje:</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="message_content" name="message_content" placeholder="Escribe el mensaje" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-8 col-sm-2">
                                                    <button type="submit" id="enviarMensaje" class="btn btn-success" disabled="disabled">Enviar!</button>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </form>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="panel-body chat-convers container-fluid">
			<?php
				$db=@mysqli_connect('localhost', 'root', 'root', 'guaunder');
				$sql="select us_like, us_target from matches_guau m where m.us_like<>'".$_SESSION['nick']."' and m.us_target='".$_SESSION['nick']."' and exists(select * from matches_guau m1 where m1.us_like='".$_SESSION['nick']."' and m1.us_target=m.us_like)";
				$consulta=mysqli_query($db,$sql);
				$i = 0;

				while ($chats = mysqli_fetch_assoc($consulta)){
					$remitente = $chats['us_like'];

					$sqlMsg = "select * from mensajes where (Destinatario='".$_SESSION['nick']."' and Remitente='".$remitente."') or (Remitente='".$_SESSION['nick']."' and Destinatario='".$remitente."')";
					$consultaMsg=mysqli_query($db,$sqlMsg);
					if(mysqli_num_rows($consultaMsg) > 0) {
						echo
					   '<div class="chat-conver msg-new" data-toggle="modal" data-target="#chatModal'.$i.'">';
				?>			<div class="col-md-3 col-xs-4">
								<span class="negrita nick">
									<?php
										echo $remitente;
									?>
								</span>
							</div>
							<div class="col-md-6 col-xs-4">
								<span class="msg-preview-new">
									<?php
										$sql2="select Cuerpo, fecha from mensajes where (Destinatario='".$_SESSION['nick']."' and Remitente='".$remitente."') or (Destinatario='".$remitente."' and Remitente='".$_SESSION['nick']."') order by fecha desc limit 1";
										$consulta2=mysqli_query($db,$sql2);
										$ultMensaje = mysqli_fetch_assoc($consulta2);
										echo $ultMensaje['Cuerpo'];
									?>
								</span>
							</div>
						</div>
				<?php	echo
						'<div id="chatModal'.$i.'" class="modal fade modalsChats container-fluid" role="dialog">'; ?>
							<div class="modal-dialog modal-lg">
						    	<div class="modal-content">
						    		<div class="modal-header">
						        		<button type="button" class="close" data-dismiss="modal">&times;</button>
						        		<?php echo '<h4 class="modal-title"><a href="perfil.php?nick='.$remitente.'" title="Ve a su perfil!">'.$remitente.'</a></h4>'; ?>
						      		</div>
						      		<div class="modal-body">
						      			<table class="table table-responsive chatMessages">
							      			<thead>
							      				<tr>
											        <th class="fechaChats">Fecha</th>
											        <th><?php echo $remitente; ?></th>
											        <th><?php echo $_SESSION['nick']; ?></th>
											        <th class="fechaChats">Fecha</th>
											    </tr>
							      			</thead>
						      			<?php
						      				$sql3="select * from mensajes where (destinatario='".$_SESSION['nick']."' and remitente='".$remitente."') or (destinatario='".$remitente."' and remitente='".$_SESSION['nick']."') order by fecha asc;";
											$consulta3=mysqli_query($db,$sql3);
										?>	<tbody> <?php
												while ($chatMensaje = mysqli_fetch_assoc($consulta3)){
													if ($chatMensaje['Remitente'] === $_SESSION['nick']) {
														?>
														<tr class="sentMessage">
															<td class="fechaChats"></td>
															<td></td>
															<td><?php echo $chatMensaje['Cuerpo'] ?></td>
															<td class="fechaChats"><?php echo $chatMensaje['fecha'] ?></td>
														</tr>
														<?php
													} else {
														?>
														<tr class="receivedMessage">
															<td class="fechaChats"><?php echo $chatMensaje['fecha'] ?></td>
															<td><?php echo $chatMensaje['Cuerpo'] ?></td>
															<td></td>
															<td class="fechaChats"></td>
														</tr>
														<?php
													}
												}
										?>	</tbody>
						      			</table>
						      			<form class="form-horizontal" method="post" action="newMessage.php">
						      				<div class="form-group">
	                                            <?php echo '<label class="control-label col-sm-offset-0 col-sm-5 col-xs-offset-2 col-xs-3" for="message_content'.$i.'">Nuevo mensaje:</label>'; ?>
	                                            <div class="col-sm-7 col-xs-7">
	                                                <?php echo '<textarea class="form-control" id="message_content'.$i.'" name="message_content" placeholder="Escribe el mensaje" rows="3"></textarea>'; ?>
	                                            </div>
	                                        </div>
	                                        <input type="hidden" name="remitente" value="<?php echo $remitente ?>">
	                                        <div class="form-group">
	                                            <div class="col-sm-offset-8 col-sm-2 col-xs-offset-6 col-xs-3">
	                                                <?php echo '<button type="submit" id="enviarMensaje'.$i.'" class="btn btn-success">Enviar!</button>'; ?>
	                                            </div>
	                                            <div class="col-sm-2 col-xs-3">
	                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	                                            </div>
	                                        </div>
						      			</form>
						    		</div>
						    	</div>
						    </div>
						</div>

			<?php
					}
					$i++;
				}

				@mysqli_close($db);
			?>
			</div>
			<div class="panel-footer">
				<span>Conectado como: <?php echo $_SESSION['nick']; ?></span>
			</div>
		</div>
	</div>

	<div id="footer"></div>

	<script>
		$(document).ready(function(){
			$( "#footer" ).load('footer.html');
		});
	</script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chats.js"></script>
	<script src="js/guaunder.js"></script>

</body>
</html>