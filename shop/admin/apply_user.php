<?php session_start();?>
<?php require_once("redirect.php")?>
<!doctype html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title>办卡信息</title>

	<?php include("header.php"); ?>


</head>
<body>
<div class="container">

	<div id="nav_bar-">
		<?php include("nav_bar.php");?>
	</div>

	<a href="apply_insert.php" class="btn btn-success" id="apply_insert" name="apply_insert">新增用户</a>

	<hr/>

	<?php
	require_once("wechat/Util/MySQL.php");
	$model_all_apply_user = MySQL::getAllApplyUser();
	$model_all_apply_status = MySQL::getAllApplyStatus();

	//把状态存储到关联数组中，openid => status
	$status = array();
	$down = array();
	foreach($model_all_apply_status as $model_apply_status) {
		$apply_status_user_id = $model_apply_status->getUserId();
		$apply_status_status = $model_apply_status->getStatus();
		$apply_status_down = $model_apply_status->getDownload();
		$status[$apply_status_user_id] = $apply_status_status;
		$down[$apply_status_user_id] = $apply_status_down;
	}

	?>

	<form role="form">
		<table class="table table-striped table-hover">
			<thead>
			<tr class="table_header">
				<th class="table_col_num">#</th>
				<th class="table_col_name">姓名</th>
				<th class="table_col_phone">手机</th>
				<th class="table_col bind">微信绑定</th>
				<th class="table_col down">导出状态</th>
				<th class="table_col_status">审核状态</th>
				<th class="table_col_oper">操作</th>
<!--				<th class="table_col_delete">删除</th>-->
			</tr>
			</thead>
			<tbody>

			<?php
			//默认显示所有商户 todo 分页处理
			$num = 1;
			foreach($model_all_apply_user as $model_apply_user):?>
				<?php
				$id = $model_apply_user->getId();
				$open_id = $model_apply_user->getOpenId();
				$user_id = $model_apply_user->getUserId();
				$user_name = $model_apply_user->getUserName();
				$user_phone = $model_apply_user->getUserPhone();
				?>
				<tr>
					<th><?=$num++?></th>
					<th><?=$user_name?></th>
					<th><?=$user_phone?></th>
					<th>
						<?php
						$title_bind = "未绑定";
						$icon_bind = "glyphicon glyphicon-remove";
						if("" != $open_id) {
							$title_bind = "已绑定";
							$icon_bind = "glyphicon glyphicon-ok";
						}
						?>
						<span class="<?=$icon_bind?>" title="<?=$title_bind?>"></span>
					</th>
					<th>
						<?php
						//标识导出状态
						$this_down = $down[$user_id];
						$title_down = "未导出";
						$icon_down = "glyphicon glyphicon-cloud";

						if(1 == $this_down) {
							$icon_down = "glyphicon glyphicon-download";
							$title_down = "已导出";
						}
						?>
						<span class="<?=$icon_down?>" title="<?=$title_down?>"></span>
					</th>
					<th>
						<?php
						//标识办卡状态
						$this_status = $status[$user_id];
						$title = "已发卡";
						$icon_class = "glyphicon glyphicon-check";

						if ( -1 == $this_status ) {
							$icon_class = "glyphicon glyphicon-question-sign";
							$title = "未审核";
						}
						else if("-2" == $this_status ) {
							$icon_class = "glyphicon glyphicon-remove";
							$title = "审核失败";
						}
						else if("0" == $this_status ) {
							$icon_class = "glyphicon glyphicon-ok";
							$title = "审核通过";
						}

						?>
						<span class="<?=$icon_class?>" title="<?=$title?>"></span>
					</th>

					<th>
						<a href="apply_check.php?id=<?=$id?>" class="btn btn-success btn-sm" role="button" title="修改办卡状态">
							<span class="glyphicon glyphicon-check" ></span>
						</a>

					</th>
<!--暂时不可删除-->
<!--					<th>-->
<!--						<a href="#" class="btn btn-danger btn-sm" role="button" title="删除">-->
<!--							<span class="glyphicon glyphicon-trash"></span>-->
<!--						</a>-->
<!--					</th>-->

				</tr>
			<?php endforeach;?>

			</tbody>

		</table>


	</form>


</div>

<style>
	.btn-sm {
		padding: 1px 8px;
	}
	.table_col_num {
		width: 80px;
	}
	.table_col_name {
		width: 180px;
	}
	.table_col_phone {
		/*width: 180px;*/
	}
	.table_col_status {
		width: 100px;
	}

	.table_col_oper {
		width:100px;
	}

	.table_col_delete {
		width:40px;
	}
	tr {
		color: #333;
	}
	th {
		font-weight: normal;
	}
</style>


</body>
</html>                                                       