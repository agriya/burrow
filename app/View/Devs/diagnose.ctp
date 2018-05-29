<div>
    <div>
        <?php echo __l('Cache folder Size: ').$tmpCacheFileSize; ?>
    </div>
    <div>
        <?php echo __l('Log folder Size: ').$tmpLogsFileSize; ?>
    </div>
    <h3><?php echo __l('Write Permission Check');?></h3>
    <ul>
    <?php echo $writable; ?>
    </ul>
    <h3><?php echo __l('Debug.log');?></h3>
    <?php echo nl2br($debugLog); ?>
    <h3><?php echo __l('Debug.log');?></h3>
    <?php echo nl2br($errorLog); ?>
</div>