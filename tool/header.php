<?php
	if(!isset($include_token) || $include_token !== "rY3NFSiEypbDOAgQ0D0KOmwj0B8A9IYsyPE/PM8pFg4agj19aM54JxWWhqOzYPrN"){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}
?>
<div class="header">
	<div class="header_center">
		<ul class="header_menu_l">
			<li>
				<a href="../index.php">
					<img src="../img/main_img/log.svg">
				</a>
			</li>
			<li class="category_li">
				<div class="category">카테고리</div>
				<ul class="category_name_ul">
					<?php
						$sql = "select category_key, category_name from category ORDER BY category_key ASC";
						$res = $connect->query($sql) or die();

						while($data = mysqli_fetch_array($res)){
							if(strlen($data["category_key"]) == 2){
								$category_1[$data["category_key"]] = $data["category_name"];
							}else if(strlen($data["category_key"]) == 4){
								$category_2[$data["category_key"]] = $data["category_name"];
							}else if(strlen($data["category_key"]) == 6){
								$category_3[$data["category_key"]] = $data["category_name"];
							}
						}

						if(isset($category_1) && count($category_1) > 0){
							foreach ($category_1 as $key_1 => $value_1) {
								$arr_check_1 = false;
								if(isset($category_2) && count($category_2) > 0){
									foreach ($category_2 as $key_2 => $value_2) {
										if(preg_match("/^".$key_1."/", $key_2)){
											$arr_check_1 = true;
											break;
										}
									}
								}
								if($arr_check_1){
									echo "<li><a class='arr' href='{$key_1}'>{$value_1}</a>";
								}else{
									echo "<li><a href='{$key_1}'>{$value_1}</a>";
								}

								if(isset($category_2) && count($category_2) > 0){
									$ul_1_check = false;
									foreach ($category_2 as $key_2 => $value_2) {
										if(preg_match("/^".$key_1."/", $key_2)){
											if(!$ul_1_check){
												$ul_1_check = true;
												echo "<ul class='category_2'>";
											}
											
											$arr_check_2 = false;
											if(isset($category_3) && count($category_3) > 0){
												foreach ($category_3 as $key_3 => $value_3) {
													if(preg_match("/^".$key_2."/", $key_3)){
														$arr_check_2 = true;
														break;
													}
												}
											}
											if($arr_check_2){
												echo "<li><a class='arr' href='{$key_2}'>{$value_2}</a>";
											}else{
												echo "<li><a href='{$key_2}'>{$value_2}</a>";
											}
											if(isset($category_2) && count($category_2) > 0){
												$ul_2_check = false;
												foreach ($category_3 as $key_3 => $value_3) {
													if(preg_match("/^".$key_2."/", $key_3)){
														if(!$ul_2_check){
															$ul_2_check = true;
															echo "<ul class='category_3'>";
														}
														echo "<li><a href='{$key_3}'>{$value_3}</a></li>";
													}
												}
												if($ul_2_check){
													echo "</ul>";
												}
											}

											echo "</li>";
										}
									}
									if($ul_1_check){
										echo "</ul>";
									}
								}
								echo "</li>";
							}
						}
					?>
				</ul>
			</li>
			<li>
				<a href="">전체상품</a>
			</li>
			<li>
				<a href="">문고 답하기</a>
			</li>
			<li>
				<a href="">공지사항</a>
			</li>

		</ul>
		<ul class="header_menu_r">
			<?php
				if(isset($_SESSION['member'])){
					$sql = "select name from member where id = '{$_SESSION['member']}'";
					$res = $connect->query($sql) or die();
					if(mysqli_num_rows($res) === 1){
			?>
			<li><a href="../mypage/changing_information.php"><?php echo mysqli_fetch_array($res)['name']; ?> 님</a></li>
			<?php
					}else{
						unset($_SESSION['member']);
						echo "<script>location.href='../index.php';</script>";
						die();
					}
				}else{
			?>
			<li>
				<a href="../login/login.php">로그인</a>
			</li>
			<li>
				<a href="../signup/join.php">회원가입</a>
			</li>
			<?php
				}
			?>
			<li>
				<a href="">장바구니</a>
			</li>
			<li>
				<a href="">주문조회</a>
			</li>
			<li>
				<a href="../mypage/changing_information.php">마이페이지</a>
			</li>
			<li>
				<a href="">찜</a>
			</li>
			<li>
				<a href="">고객센터</a>
			</li>
			<?php
				if(isset($_SESSION['member'])){
			?>
			<li><a href="../login/logout.php">로그아웃</a></li>
			<?php
				}
			?>
			<li class="search">
				<input type="text">
				<img src="../img/main_img/magnifier.svg">
			</li>
		</ul>
	</div>
</div>