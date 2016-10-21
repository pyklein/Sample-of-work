<?php use_helper("Message"); ?>

<?php if (!isset($intIdPager)) {$intIdPager = 0;} ?>
<?php $strParams = $strUrlRedirection[1] != "" ? $strUrlRedirection[1].'&' :  $strUrlRedirection[1] ?>

<div class="pagination">

  <?php if ($objPager->getPage() != 1) { ?>
    <?php echo link_to('<<', $strUrlRedirection[0],array('query_string' => $strParams."page_" . $intIdPager."=1")); ?>
    <?php echo link_to('<', $strUrlRedirection[0],array('query_string' => $strParams."page_" . $intIdPager."=" . $objPager->getPreviousPage())); ?>
  <?php } else { ?>
      <span><<</span>
      <span><</span>
  <?php } ?>

  <?php $intDernierAffiche = 0; ?>
  <?php foreach ($objPager->getLinks($objPager->getNbResults()) as $page): ?>
    <?php if ($page == $objPager->getPage()): ?>
      <span><?php echo $page ?></span>
      <?php $intDernierAffiche = $page; ?>
    <?php elseif (in_array($page, array(1, 2, 3,
                                        $objPager->getPage() - 1,
                                        $objPager->getPage() + 1,
                                        $objPager->getLastPage() - 2,
                                        $objPager->getLastPage() - 1,
                                        $objPager->getLastPage()))): ?>
      <?php if ($intDernierAffiche < $page - 1) : ?>
        ...
      <?php endif; ?>
      <?php $intDernierAffiche = $page; ?>
      <?php echo link_to($page,$strUrlRedirection[0],array('query_string' => $strParams."page_" . $intIdPager."=" . $page)) ?>
    <?php endif; ?>
  <?php endforeach; ?>


  <?php if ($objPager->getPage() != $objPager->getLastPage()) { ?>
    <?php echo link_to('>', $strUrlRedirection[0],array('query_string' => $strParams."page_" . $intIdPager."=" . $objPager->getNextPage())); ?>
    <?php echo link_to('>>', $strUrlRedirection[0],array('query_string' => $strParams."page_" . $intIdPager."=" . $objPager->getLastPage())); ?>
  <?php } else { ?>
    <span>></span>
    <span>>></span>
  <?php } ?>

  <br />
  <?php echo libelle("msg_libelle_page_sur", array($objPager->getPage(), $objPager->getLastPage())); ?>

</div>
