<div  ng-controller="Links.links.edit" ng-init="init()">

	<div class="panel panel-default" ng-repeat="(categoryIndex, linkCategory) in linkCategories">

		<div class="panel-heading">
			{{linkCategory.LinkCategory.name}}
		</div>
		<!--		link loop -->
		<div class="panel-body" ng-repeat="(linkIndex, link) in linkCategory.links">
			<div class="row">
				<?php
				$url = 'http://www.netcommons.org/';
				$title = 'NetCommons2公式サイト';
				$description = '本サイトは情報共有基盤システムNetCommonsの公式サイトです。 本サイトは国立情報学研究所NetCommonsプロジェクトにより運営されています。';
				?>

				<?php echo $this->element('content_move_btn', array('size' => '12 col-md-1', 'upDisabled' => true, 'moveParams' => array('categoryIndex', 'linkIndex'))); ?>

				<div class="col-xs-12  col-md-11">
					<div>
						<a href="{{link.Link.url}}" target="_blank">
							{{link.Link.title}}
						</a>
						<span class="animate-switch-container"
							 ng-switch on="link.Link.status">
<!--							MyTodo この4行をng-includeで読みこんだらどうか？-->
							<span class="label label-danger" ng-switch-when="2">申請中</span>
							<span class="label label-info" ng-switch-when="3">下書き</span>
							<span class="label label-warning" ng-switch-when="4">差し戻し</span>
							<div ng-switch-default></div>
						</span>
					</div>
					<div class="small" style="margin-top: 5px;">
						{{link.Link.description}}
					</div>
				</div>
				<?php echo $this->element('LinkEdit/content_edit_btn_link', array(
						'published' => false,
						'size' => 12,
						'url' => $url,
						'title' => $title,
						'description' => $description)); ?>

			</div>
		</div>

	</div>


</div>

<!--MyTodo ここから下は削除-->
<div class="panel panel-default">
 	<div class="panel-heading">
		カテゴリ２
	</div>
 	<div class="panel-body">
		<div class="row">

			<?php
				$url = 'http://researchmap.jp/';
				$title = 'researchmap';
				$description = 'Researchmap is an information sharing platform for the researchers. Researchmap is provided by Japan';
			?>

			<?php echo $this->element('content_move_btn', array('size' => '12 col-md-1')); ?>

			<div class="col-xs-12  col-md-11">
				<div>
					<a href="<?php echo $url; ?>" target="_blank">
						<?php echo $title; ?>
					</a>
					<span class="label label-danger">申請中</span>
				</div>
				<div class="small" style="margin-top: 5px;">
					<?php echo $description; ?>
				</div>
			</div>

			<?php echo $this->element('LinkEdit/content_edit_btn_link', array(
				'published' => true,
				'size' => 12,
				'url' => $url,
				'title' => $title,
				'description' => $description)); ?>

		</div>
	</div>

 	<div class="panel-body">

		<div class="row">

			<?php
				$url = 'http://demo.edumap.jp';
				$title = 'edumap';
				$description = '';
			?>

			<?php echo $this->element('content_move_btn', array('size' => '12 col-md-1')); ?>

			<div class="col-xs-12  col-md-11">
				<div>
					<a href="<?php echo $url; ?>" target="_blank">
						<?php echo $title; ?>
					</a>
					<span class="label label-info">下書き</span>
				</div>
				<div class="small" style="margin-top: 5px;">
					<?php echo $description; ?>
				</div>
			</div>

			<?php echo $this->element('LinkEdit/content_edit_btn_link', array(
				'published' => false,
				'size' => 12,
				'url' => $url,
				'title' => $title,
				'description' => $description)); ?>

		</div>
	</div>

 	<div class="panel-body">

		<div class="row">

			<?php
				$url = 'http://www.nii.ac.jp';
				$title = '国立情報学研究所';
				$description = '国立情報学研究所は、情報学という新しい研究分野での「未来価値創成」を目指すわが国唯一の学術総合研究所として、ネットワーク、ソフトウェア、コンテンツなどの情報関連分野の新しい理論・方法論から応用展開までの研究開発を総合的に推進しています。';
			?>

			<?php echo $this->element('content_move_btn', array('size' => '12 col-md-1', 'downDisabled' => true)); ?>

			<div class="col-xs-12  col-md-11">
				<div>
					<a href="<?php echo $url; ?>" target="_blank">
						<?php echo $title; ?>
					</a>
					<span class="label label-warning">差し戻し</span>
				</div>
				<div class="small" style="margin-top: 5px;">
					<?php echo $description; ?>
				</div>
			</div>

			<?php echo $this->element('LinkEdit/content_edit_btn_link', array(
				'published' => false,
				'size' => 12,
				'url' => $url,
				'title' => $title,
				'description' => $description)); ?>

		</div>

	</div>
</div>

<p class="text-center">
	<button type="button" class="btn btn-default" ng-click="cancel()">
		閉じる
	</button>
</p>
