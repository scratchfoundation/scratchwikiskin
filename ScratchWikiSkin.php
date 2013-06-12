<?php
/**
 * Scratch skin
 *
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 1 );
}

#require_once( dirname( dirname( __FILE__ ) ) . '/includes/SkinTemplate.php');

class SkinScratchWikiSkin extends SkinTemplate{
	var $useHeadElement = true;

	var $skinname = 'scratchwikiskin', $stylename = 'scratchwikiskin',
	$template = 'ScratchWikiSkinTemplate';
	
	function initPage(OutputPage $out) {
		

		parent::initPage( $out );

		
	}
	
	function setupSkinUserCss(OutputPage $out) {
		global $wgLocalStylePath;
		parent::setupSkinUserCss($out);
		$out->addStyle('scratchwikiskin/main.css', 'screen');
		
		$out->addHeadItem('skinscript', "<script type='text/javascript' src='$wgLocalStylePath/scratchwikiskin/skin.js'></script>");
	}
}

class ScratchWikiSkinTemplate extends BaseTemplate{
	public function execute() {
		global $wgRequest, $wgStylePath, $wgUser;
		$skin = $this->data['skin'];
		wfSuppressWarnings();
		$this->html('headelement');
		
		?>
<header>
	<div class=container>
		
			<a class= "scratch" href = "http://scratch.mit.edu"></a>
		
		<ul class=left>
			<li><a href="http://scratch.mit.edu/projects/editor/">Create</a>
			<li><a href="http://scratch.mit.edu/explore/?date=this_month">Explore</a>
			<li><a href="http://scratch.mit.edu/discuss/">Discuss</a>
			<li class = last><a href="http://scratch.mit.edu/help/">Help</a>
		
		<!-- search -->
			<li>
				<form action="<?php $this->text( 'wgScript' ) ?>" class="search">
					<span class="glass"><i></i></span>
					<input type="search" id="searchInput" accesskey="f" title="Search Scratch Wiki [alt-shift-f]"  name="search" autocomplete="off" placeholder="Search the Wiki">
					<!--<input type="submit" class="searchButton" id="searchGoButton" title="Go to a page with this exact name if exists" value="Go" name="go">-->
					<input type="hidden" class="searchButton" id="mw-searchButton" title="Search the pages for this text" value="Search" name="fulltext">
					<input type="hidden" value="Special:Search" name="title">
				</form>
			</li>
		</ul>
		<ul class="user right">
			
			
			<!-- user links -->
<?php	if (!$wgUser->isLoggedIn()) { ?>
			<!--<li class = last><a href=" 	Special:Userlogin">Log in to the Wiki</a></li>-->
			<li class = last><a href="<?php if (isset($this->data['personal_urls']['anonlogin'])){echo $this->data['personal_urls']['anonlogin']['href'];}else{echo $this->data['personal_urls']['login']['href'];}?>">Log in to the Wiki</a></li>
<?php	} else { ?>
			<li id=userfcttoggle class="user-name dropdown-toggle"><a><?=htmlspecialchars($wgUser->mName)?></a></li>
			<ul id=userfctdropdown class=dropdownmenu><?php foreach ($this->data['personal_urls'] as $key => $tab):?>
				<li<?php if ($tab['class']):?> class="<?=htmlspecialchars($tab['class'])?>"<?php endif?>><a href="<?=htmlspecialchars($tab['href'])?>"<?=$skin->tooltipAndAccesskeyAttribs("ca-$key")?>><?=htmlspecialchars($tab['text'])?></a><?php endforeach?>
			</ul>
<?php	} ?>
		</ul>
	</div>
</header>
<div class="container main">
	<div class=main-inner>
		<div class=left>
		<div class = "wikilogo_space"><a class = "wikilogo" href = "<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ); ?>" title = "Scratch Wiki Main Page"></a></div>
<?php		foreach ($this->getSidebar() as $box): if ($box['header']!='Toolbox'||$wgUser->isLoggedIn()){?>
			<div class=box>
				<!-- <?=print_r($box);?> -->
				<h1><?=htmlspecialchars($box['header'])?></h1>
<?php			if (is_array($box['content'])):?>
				<ul class=box-content>
<?php				foreach ($box['content'] as $name => $item):?>
					<?=$this->makeListItem($name, $item)?>
<?php				endforeach;
			else:?>
				<?=$box['content']?>
<?php			endif?>
			</div>
<?php		} endforeach?>
<?php		$this->renderContenttypeBox();
			if (!$wgUser->isLoggedIn()) { ?>
			<div class=box>
				
				<h1>Help the wiki!</h1>
				<div class=box-content>
				The Scratch Wiki is made by and for Scratchers. Do you want to contribute?<br><br><a href="/wiki/Contribute_to_the_Scratch_Wiki">Learn more!</a>
				</div>
				
			</div>
<?php		} ?>
		</div>
		<div class=right>
			<article class=box>
				<h1><?php $this->html('title')?><div id=pagefctbtn></div>
				<ul id=pagefctdropdown class="dropdownmenu box">
<?				foreach ($this->data['content_actions'] as $key => $tab):?>
					<?=$this->makeListItem($key, $tab)?>
<?				endforeach?>
				</ul>
			</nav>
				</ul>				
				</h1>
				<div class=box-content>
<?php if ($this->data['subtitle']):?><p><?php $this->html('subtitle')?></p><?php endif?>
<?php if ($this->data['undelete']):?><p><?php $this->html('undelete')?></p><?php endif?>
<?php $this->html('bodytext')?>
<?php if ( $this->data['catlinks'] ): ?>
<!-- catlinks -->
<?php $this->html( 'catlinks' ); ?>
<!-- /catlinks -->
<?php endif; ?>
				</div>
			</article>
		</div>
	</div>
</div>
<footer>
	<ul>
		<li><a href>About</a></li>
		<li><a href>Educators</a></li>
		<li><a href>Parents</a></li>
		<li><a href>Community Guidelines</a></li>
		<li><a href>Contact Us</a></li>
	</ul>
	<p>Scratch is a project of the Lifelong Kindergarten Group at the MIT Media Lab</p>
</footer>
		<?php

	}
	protected function renderContenttypeBox() {
		global $wgStylePath;
		//content type identification box. to be moved somwhere else (cleaner).
		if( $this->data['catlinks'] ) {
			$cat = $this->data['catlinks'];
			if(strpos($cat, 'Tutorials')>0 || strpos($cat, 'FAQ')>0 || strpos($cat, 'Help Pages')>0) {
				$contenttype = 'helppage';
			} else if(strpos($cat, 'Portals')>0) {
				$contenttype = 'portal';
			} else {
				$contenttype = 'descriptive';
			}
		} else {
			//not good. we need a better way to find out when not to content-categorize a page.
			$contenttype = 'descriptive';
		}
			
		$titles = Array('descriptive'=>'Information Page', 'helppage'=>'How-to Page', 'portal'=>'Portal');	
		$info   = Array(
			'descriptive'	=> 'This page has information, facts, and history about this subject.',
			'helppage'		=> 'This page provides step-by-step help on how to do something.',
			'portal'		=> 'This page contains links to help you find the information you\'re looking for.');
		$o =	'<div class="box ctype ctype-'.$contenttype.'">'.
			 	'<h1>'.$titles[$contenttype].'</h1>'.
				'<div class=box-content>'./*'<img src="'.$wgStylePath.'/s2cookie/ctype-'.$contenttype.'.png"></img><br>'*/
				$info[$contenttype].'</div>'.
				'</div>';
		if ($contenttype!='portal') {
			echo $o;
		}
	}
}
