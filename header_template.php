<div id="top_menu">
					<a href="index.php"><img src="logo.png" id="logo" align="left"></a>
					<div id="general_menu">
						<div class="dropdown">
							<button id="cart_button">Shopping Cart</button>
							<div class="dropdown_content" id = "dropdown_content_id">
								<script>
									function order() {
										window.location = "order.php";
									}
								</script>
								
								<?php
									if(isset($_SESSION["user"])){
										$sql = "SELECT 1 FROM ShoppingCart WHERE customerID = ".$_SESSION['user'];
										$sql = $conn->prepare($sql);
										$sql->execute();
										$isset = $sql->fetch(PDO::FETCH_ASSOC);
										if($isset) {
											?>
												<table style="text-align: left;">
												<tr>
												<th style="min-width: 150px; text-align: left;">Name</th>
												<th>Quantity</th>
												<th>Price</th>
												</tr>
			
											<?php
											$articles = "
											SELECT name FROM Articles WHERE id IN (
												SELECT articleID FROM ShoppingCart WHERE customerID = ".$_SESSION['user']."
											)";
			
											$cart = "SELECT quantity, price, articleID FROM ShoppingCart WHERE customerID = ".$_SESSION['user'];
											$cart = $conn->prepare($cart);
											$cart->execute();
				
											echo '<form action="/~olfjoh-5/order.php" method="post">';
											
											$total=0;
											foreach ($conn->query($articles) as $row) {
												$result = $cart->fetch(PDO::FETCH_ASSOC);
												$total = $total+$result['price']*$result['quantity'];
									    			echo "<tr>";
													echo "<td>".$row['name']."</td>";
													echo '<input type="hidden" name="id[]" value="'.$result['articleID'].'">';
													echo '<td><input type="number" name="quantity[]" style="width:40px" min="1" value="'.$result['quantity'].'". required></td>';
													echo "<td>".$result['price'] * $result['quantity'].":-</td>";
													echo "<td><b><a href='order.php?remove=".$result['articleID']."'><img src='./gfx/Kryss.png' style='height: 10px;'/></a></b></td>";
									    			echo "</tr>";
									    		}
									    		
									    		?>
												    	</table>
												    	
											    		<p><b>Total:</b> <?php echo $total; ?>:- </p>
												    	<input type="submit" name="checkout" value="Go to checkout" />
												    	<input type="submit" name="save" value="Save changes" />
											    	</form>
											<?php
										}
										else{
										    	echo "<p style='color: black;'>The shopping cart is empty</p>";
										    	
										}
									}
								?>
								
							</div>
						</div>
						<button id="profile_button"><a href="./profile.php">My Profile</a></button>
						<div class="dropdown">
							<button id="login_button">Login</button>
							<div class="dropdown_content">
							<?php if(isset($_SESSION["user"])) {?>
										<script>
											document.getElementById('profile_button').style.display='inline';
											document.getElementById('cart_button').style.display='inline';
											document.getElementById('login_button').style.display='none';
											document.getElementById('sign_up_button').style.display='none';
										</script>
									<?php }
									else{?>
										<script>
											document.getElementById('profile_button').style.display='none';
											document.getElementById('cart_button').style.display='none';
											document.getElementById('login_button').style.display='inline';
											document.getElementById('sign_up_button').style.display='inline';
										</script>
										<form action="./login.php" method="post" class='menu_text'>
											<input type="text" name="email" placeholder="Email" required=true><br>
											<input type="password" name="pwd" placeholder="Password" required=true><br>
											<input type="submit" id="login" value="Login" />
										</form>
									<?php }	?>
							</div>
						</div>
						<?php if(isset($_SESSION["user"])) { ?>
							<form style="float: right; margin-left: 5px;" action="./login.php" method="post">
								<input type="submit" id="buy" name="logout" value="Log out"/>
							</form>
						<?php }?>
						<div class="dropdown">
							<button id="sign_up_button">Sign up</button>
							<div class="dropdown_content">
							<?php if(isset($_SESSION["user"])) {?>
										<script>
											document.getElementById('profile_button').style.display='inline';
											document.getElementById('cart_button').style.display='inline';
											document.getElementById('login_button').style.display='none';
											document.getElementById('sign_up_button').style.display='none';
										</script>
									<?php }
									else{?>
										<form action="./signUp.php" method="post" id="form" name="form"> 
										
											<input type="email" id="email" name="email" placeholder="Email" required=true/> <br />
											<input type="password" id="pwd" name="pwd" placeholder="Password" required=true <br />

											<input type="submit" id="createAccount" value="Create" />
										</form>
										<script>
											document.getElementById('profile_button').style.display='none';
											document.getElementById('cart_button').style.display='none';
											document.getElementById('login_button').style.display='inline';
											document.getElementById('sign_up_button').style.display='inline';
										</script>
									<?php }	?>
							</div>
						</div>
						<button class="login"><a href="./customer_service.php">Customer Service</a></button>
						
						<div style="float:right; margin-left: 5px;">
							<?php
								if(isset($_SESSION['user'])){
									$query = "SELECT isAdmin FROM Accounts WHERE id =".$_SESSION['user'];
									$query = $conn->prepare($query);
									$query->execute();
									$result = $query->fetch(PDO::FETCH_ASSOC);

									if($result['isAdmin']) {
									?>
										<a href="admin.php"><button>Admin page</button></a>
									<?php
									}
								}
							?>
						</div>
					</div>
				</div>
				
				<div id="article_menu">
					<table>
						<tr>
							<td>
								<div class="dropdown">
									<form>
										<?php
								    			$sql = "SELECT category FROM Articles"; 
								    			$catArr = array();
											foreach ($conn->query($sql) as $row) {
												if(!(in_array($row['category'], $catArr))){
													$catArr[] = ($row['category']);
												}	
											}
										?>
										<select onchange="location = this.value;">
											<option selected disabled hidden>Categories</option>
											<?php
												foreach($catArr as $cat){
													echo "<option value='category.php?category=".$cat."'>".$cat."</option>";
												}
											?>
										</select>
									</form>	
								</div>
								
							</td>
							<td>
								<button><a href="./toplist.php">Toplist</a></button>
							</td>
							<td>
								<form action="./search.php" method="get">
									<input type="text" name="search" placeholder="search">
									<select name="filters">
										<option value="all">All</option>
										<option value="lowest price">Lowest price</option>
										<option value="highest price">Highest price</option>
										<option value="newest">Newest</option>
										<option value="highest rate">Highest rate</option>
										<option value="lowest rate">Lowest rate</option>
									</select>
									<input type="submit" id="search" value="Search"/>
								</form>
							</td>
						</tr>
					</table>
					<?php 
				if( ! empty($_SESSION['login_error_msg']))
				{
				    echo "<p style='color: red;'>".$_SESSION['login_error_msg']."</p>";
				    unset($_SESSION['login_error_msg']);
				}
				if( ! empty($_SESSION['buy_error_msg']))
				{
				    echo "<p style='color: red;'>".$_SESSION['buy_error_msg']."</p>";
				    unset($_SESSION['buy_error_msg']);
				}
				if( ! empty($_SESSION['image_error_msg']))
				{
				    echo "<p style='color: red;'>".$_SESSION['image_error_msg']."</p>";
				    unset($_SESSION['image_error_msg']);
				}
				
			?>
				</div>
				
				
				
				