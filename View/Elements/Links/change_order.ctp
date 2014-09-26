<div class="panel panel-default">
 	<div class="panel-heading">
		カテゴリ１
	</div>
 	<div class="panel-body">
		<div class="row">
			<?php
				$url = 'http://www.netcommons.org/';
				$title = 'NetCommons2公式サイト';
				$description = '本サイトは情報共有基盤システムNetCommonsの公式サイトです。 本サイトは国立情報学研究所NetCommonsプロジェクトにより運営されています。';
			?>

			<?php echo $this->element('Links/content_move_btn', array('size' => '2 col-md-1', 'upDisabled' => true)); ?>

			<div class="col-xs-10  col-md-11">
				<div>
					<a href="<?php echo $url; ?>" target="_blank">
						<?php echo $title; ?>
					</a>
				</div>
				<div class="small" style="margin-top: 5px;">
					<?php echo $description; ?>
				</div>
			</div>

			<?php echo $this->element('Links/content_edit_btn_link', array(
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
				$url = 'http://legacy.netcommons.org';
				$title = 'NetCommonsLegacy公式サイト';
				$description = '本サイトはe-ラーニング・情報共有の基盤として国立情報学研究所が提供しているNetCommonsの公式サイトです。';
			?>

			<?php echo $this->element('Links/content_move_btn', array('size' => '2 col-md-1')); ?>

			<div class="col-xs-10  col-md-11">
				<div>
					<a href="<?php echo $url; ?>" target="_blank">
						<?php echo $title; ?>
					</a>
				</div>
				<div class="small" style="margin-top: 5px;">
					<?php echo $description; ?>
				</div>
			</div>

			<?php echo $this->element('Links/content_edit_btn_link', array(
				'published' => false,
				'size' => 12,
				'url' => $url,
				'title' => $title,
				'description' => $description)); ?>

		</div>

	</div>
</div>


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

			<?php echo $this->element('Links/content_move_btn', array('size' => '2 col-md-1')); ?>

			<div class="col-xs-10  col-md-11">
				<div>
					<a href="<?php echo $url; ?>" target="_blank">
						<?php echo $title; ?>
					</a>
					<span class="label label-danger">公開申請中</span>
				</div>
				<div class="small" style="margin-top: 5px;">
					<?php echo $description; ?>
				</div>
			</div>

			<?php echo $this->element('Links/content_edit_btn_link', array(
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

			<?php echo $this->element('Links/content_move_btn', array('size' => '2 col-md-1')); ?>

			<div class="col-xs-10  col-md-11">
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

			<?php echo $this->element('Links/content_edit_btn_link', array(
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

			<?php echo $this->element('Links/content_move_btn', array('size' => '2 col-md-1', 'downDisabled' => true)); ?>

			<div class="col-xs-10  col-md-11">
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

			<?php echo $this->element('Links/content_edit_btn_link', array(
				'published' => false,
				'size' => 12,
				'url' => $url,
				'title' => $title,
				'description' => $description)); ?>


		</div>

	</div>
</div>


<p class="text-center">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		キャンセル
	</button>
	<button type="button" class="btn btn-primary" data-dismiss="modal">
		設定する
	</button>
</p>
