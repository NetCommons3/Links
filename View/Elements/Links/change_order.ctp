<div class="panel panel-default">
 	<div class="panel-heading">
		カテゴリ１
	</div>
 	<div class="panel-body">
		<div class="row">
			<?php echo $this->element('Links/content_move_btn', array('size' => 1)); ?>

			<div class="col-xs-8">
				<div>
					<a href="http://www.netcommons.org/" target="_blank">
						NetCommons2公式サイト
					</a>
				</div>
				<div class="small" style="margin-top: 5px;">
					本サイトは情報共有基盤システムNetCommonsの公式サイトです。 本サイトは国立情報学研究所NetCommonsプロジェクトにより運営されています。
				</div>
			</div>

			<?php echo $this->element('Links/content_edit_btn', array('published' => false, 'size' => 3)); ?>
		</div>
	</div>

 	<div class="panel-body">

		<div class="row">
			<?php echo $this->element('Links/content_move_btn', array('size' => 1)); ?>

			<div class="col-xs-8">
				<div>
					<a href="http://legacy.netcommons.org" target="_blank">
						NetCommonsLegacy公式サイト
					</a>
				</div>
				<div class="small" style="margin-top: 5px;">
					本サイトはe-ラーニング・情報共有の基盤として国立情報学研究所が提供しているNetCommonsの公式サイトです。
				</div>
			</div>

			<?php echo $this->element('Links/content_edit_btn', array('published' => false, 'size' => 3)); ?>
		</div>

	</div>
</div>


<div class="panel panel-default">
 	<div class="panel-heading">
		カテゴリ２
	</div>
 	<div class="panel-body">
		<div class="row">
			<?php echo $this->element('Links/content_move_btn', array('size' => 1)); ?>

			<div class="col-xs-8">
				<div>
					<a href="http://researchmap.jp/" target="_blank">
						researchmap
						<span class="label label-danger">公開申請中</span>
					</a>
				</div>
				<div class="small" style="margin-top: 5px;">
					Researchmap is an information sharing platform for the researchers. Researchmap is provided by Japan
				</div>
			</div>

			<?php echo $this->element('Links/content_edit_btn', array('published' => true, 'size' => 3)); ?>
		</div>
	</div>

 	<div class="panel-body">

		<div class="row">
			<?php echo $this->element('Links/content_move_btn', array('size' => 1)); ?>

			<div class="col-xs-8">
				<div>
					<a href="http://demo.edumap.jp" target="_blank">
						edumap
						<span class="label label-info">下書き</span>
					</a>
				</div>
			</div>

			<?php echo $this->element('Links/content_edit_btn', array('published' => false, 'size' => 3)); ?>
		</div>
	</div>

 	<div class="panel-body">

		<div class="row">
			<?php echo $this->element('Links/content_move_btn', array('size' => 1)); ?>

			<div class="col-xs-8">
				<div>
					<a href="http://www.nii.ac.jp" target="_blank">
						国立情報学研究所
						<span class="label label-warning">差し戻し</span>
					</a>
				</div>
				<div class="small" style="margin-top: 5px;">
					国立情報学研究所は、情報学という新しい研究分野での「未来価値創成」を目指すわが国唯一の学術総合研究所として、ネットワーク、ソフトウェア、コンテンツなどの情報関連分野の新しい理論・方法論から応用展開までの研究開発を総合的に推進しています。
				</div>
			</div>

			<?php echo $this->element('Links/content_edit_btn', array('published' => false, 'size' => 3)); ?>
		</div>

	</div>
</div>
