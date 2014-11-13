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
	<div class="container">
		
			<a class= "scratch" href = "http://scratch.mit.edu"></a>
		
		<ul class="left">
			<li></li>
			<li></li>
			<li></li>
			<li class = "last"></li>
		
		<!-- search -->
			<li>
				<form action="<?php $this->text( 'wgScript' ) ?>" class="search">
					<!--<span class="glass"><i></i></span>-->
					<input type= "submit" class= "glass" value= ""> 
					<input type="search" id="searchInput" accesskey="f" title="Search Scratch Wiki [alt-shift-f]"  name="search" autocomplete="off" placeholder="Search the Wiki"  />
					<!--<input type="submit" class="searchButton" id="searchGoButton" title="Go to a page with this exact name if exists" value="Go" name="go">-->
					<input type="hidden" class="searchButton" id="mw-searchButton" title="Search the Everything Wiki!" value="Search" />
					<input type="hidden" value="Special:Search" name="title" />
				</form>
			</li>
		</ul>
		<ul class="user right">
			
			
			<!-- user links -->
<?php	if (!$wgUser->isLoggedIn()) { ?>
			<!--<li class = last><a href=" 	Special:Userlogin">Log in to the Wiki</a></li>-->
			<li class = last><a href="<?php if (isset($this->data['personal_urls']['anonlogin'])){echo htmlspecialchars($this->data['personal_urls']['anonlogin']['href']);}else{echo $this->data['personal_urls']['login']['href'];}?>">Log in to the Wiki</a></li>
<?php	} else { ?>
			<li id="userfcttoggle" class="last"><a><?=htmlspecialchars($wgUser->mName)?><span class = caret></span></a></li>
			<ul id=userfctdropdown class="dropdownmenu"><?php foreach ($this->data['personal_urls'] as $key => $tab):?>
				<li<?php if ($tab['class']):?> class="<?=htmlspecialchars($tab['class'])?>"<?php endif?>><a href="<?=htmlspecialchars($tab['href'])?>"><?=htmlspecialchars($tab['text'])?></a><?php endforeach?>
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
				?>
				</ul>
<?php
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
				The Scratch Wiki is made by and for Scratchers. Do you want to contribute?<br><br>
				<a href="/wiki/Contribute_to_the_Scratch_Wiki">Learn more about joining as an editor!</a><br><br>
				<a href = "/wiki/Scratch_Wiki_talk:Community_Portal">See discussions in the Community Portal</a>
				</div>
				
			</div>
<?php		} ?>
		</div>
		<div class=right>
			<?php if( $this->data['newtalk'] ) { ?><div class="box"><h1><?php $this->html('newtalk') ?></h1></div><?php } ?>
			<?php if( $this->data['catlinks'] && $wgUser->isLoggedIn()) {
			$cat = $this->data['catlinks'];
			if(strpos($cat, 'How To Pages')> 0) {
				$o =	'<div class="box ctype ctype-helppage">'.
			 	'<h1>How To page</h1>'.
				'<div class=box-content>'.
				'This page provides step-by-step help on how to do something for new users. Before editing, please read the <a href = /wiki/Help:How_To_pages>How To page guidelines.</a></div>'.
				'</div>';
				echo $o;
				

			} 
			
		} 	?>
			<article class=box>
				<h1><?php $this->html('title')?>
				<div id=pagefctbtn></div>
				<ul id=pagefctdropdown class="dropdownmenu box">
<?				foreach ($this->data['content_actions'] as $key => $tab):?>
					<?=$this->makeListItem($key, $tab)?>
<?				endforeach?>
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
<?php   
// generate additional footer links
$footerlinks = array(
        'lastmod', 
// 'viewcount',
);
?>
        		<ul id="f-list">
<?php
foreach ( $footerlinks as $aLink ) {
        if ( isset( $this->data[$aLink] ) && $this->data[$aLink] ) {
?>              		<li id="<?php echo $aLink ?>"><?php $this->html( $aLink ) ?></li>
<?php   }
}
?>
        		</ul>
		</div>
	</div>
</div>
<footer>
	<div class="container">
        
        <style>
          footer ul.footer-col li {
            list-style-type:none;
            display: inline-block;
            width: 184px;
            text-align: left;
            vertical-align: top;
          }

          footer ul.footer-col li h4 {
            font-weight: bold;
            font-size: 14px;
            color: #666;
          }


        </style>
          <ul class="clearfix footer-col">
            <li>
              <h4>About</h4>
              <ul>
                <li><a href ="http://scratch.mit.edu/about/">About Scratch</a></li>
                <li><a href = "http://scratch.mit.edu/parents/">For Parents</a></li>
                <li><a href = "http://scratch.mit.edu/educators/">For Educators</a></li>
                <li><a href ="http://scratch.mit.edu/jobs/">Jobs</a></li>
              </ul>
            </li> 
          </ul>
<br>
<p >Scratch is a project of the Lifelong Kindergarten Group at the MIT Media Lab</p>
</footer>

        <?php $this->printTrail(); ?>

		<?php

	}
	protected function renderContenttypeBox() {
		global $wgStylePath, $wgUser;
		
		//content type identification box. to be moved somewhere else (cleaner).
#		if( $this->data['catlinks'] && $wgUser->isLoggedIn()) {
#			$cat = $this->data['catlinks'];
#			if(strpos($cat, 'How To Pages')> 0) {
#				$o =	'<div class="box ctype ctype-helppage">'.
#			 	'<h1>How To page</h1>'.
#				'<div class=box-content>'.
#				'This page provides step-by-step help on how to do something for new users. Before editing, please read the How To page <a href = /wiki/Help:How_To_pages>guidelines.</a></div>'.
#				'</div>';
#				echo $o;
#				

#			} 
#			
#		} 	
		
		
		
	}
}
