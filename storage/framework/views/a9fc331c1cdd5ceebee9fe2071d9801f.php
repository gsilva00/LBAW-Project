<?php
    $user = Auth::user();
    $pair_users = [$notification->getRecipientDisplayNameAttribute(), $notification->getSenderDisplayNameAttribute()];
    $notification_specifics = $notification->getSpecificNotification();

    $first_condition = ($notification_specifics[0] === 3 || $notification_specifics[0] === 4 || $notification_specifics[0] === 5) && $user->upvote_notification;
    $second_condition = ($notification_specifics[0] === 1 || $notification_specifics[0] === 2) && $user->comment_notification;
?>
<?php if($first_condition || $second_condition): ?>
    <?php if($notification->is_viewed): ?>
        <div class="notification-card greyer" notification_id="<?php echo e($notification->id); ?>">
    <?php else: ?>
        <div class="notification-card" notification_id="<?php echo e($notification->id); ?>">
    <?php endif; ?>
        <?php if($notification_specifics[0] === 1): ?>
            <div class="profile-info">
            <p><i class='bx bx-comment'></i>
            <?php if($pair_users[1][0] === $user->display_name): ?>
                <a href="<?php echo e(route('profile', ['username' => $pair_users[1][1]])); ?>">You</a>
            <?php else: ?>
                <a href="<?php echo e(route('profile', ['username' => $pair_users[1][1]])); ?>"><?php echo e($pair_users[1][0]); ?></a>
            <?php endif; ?>
             commented on your article</p>
        
             <button type="button" class="small-rectangle" onclick="window.location.href='<?php echo e(route('showArticle', ['id' => $notification_specifics[1]->comment->article_id])); ?>'">
                <i class='bx bx-show remove-position' ></i>
                View Comment
            </button> 
        <?php elseif($notification_specifics[0] === 2): ?>
            <div class="profile-info">
            <p><i class='bx bx-comment'></i>
            <?php if($pair_users[1][0] === $user->display_name): ?>
                <a href="<?php echo e(route('profile', ['username' => $pair_users[1][1]])); ?>">You</a>
            <?php else: ?>
                <a href="<?php echo e(route('profile', ['username' => $pair_users[1][1]])); ?>"><?php echo e($pair_users[1][0]); ?></a>
            <?php endif; ?>
             replied "<?php echo e($notification_specifics[1]->reply->content); ?>" on the comment "<?php echo e($notification_specifics[1]->reply->comment->content); ?>" from your article</p>
            
             <button type="button" class="small-rectangle" onclick="window.location.href='<?php echo e(route('showArticle', ['id' => $notification_specifics[1]->reply->comment->article_id])); ?>'">
                <i class='bx bx-show remove-position' ></i>
                View Reply
            </button>      
        <?php elseif($notification_specifics[0] === 3): ?>
            <div class="profile-info">
            <p><i class='bx bx-comment'></i>
            <?php if($pair_users[1][0] === $user->display_name): ?>
                <a href="<?php echo e(route('profile', ['username' => $pair_users[1][1]])); ?>">You</a>
            <?php else: ?>
                <a href="<?php echo e(route('profile', ['username' => $pair_users[1][1]])); ?>"><?php echo e($pair_users[1][0]); ?></a>
            <?php endif; ?>
             upvoted on your article</p>
            
             <button  type="button" class="small-rectangle" onclick="window.location.href='<?php echo e(route('showArticle', ['id' => $notification_specifics[1]->article_id])); ?>'">
                <i class='bx bx-show remove-position' ></i>
                View Comment
            </button>       
        <?php elseif($notification_specifics[0] === 4): ?>
            <div class="profile-info">
            <p><i class='bx bx-comment'></i>
            <?php if($pair_users[1][0] === $user->display_name): ?>
                <a href="<?php echo e(route('profile', ['username' => $pair_users[1][1]])); ?>">You</a>
            <?php else: ?>
                <a href="<?php echo e(route('profile', ['username' => $pair_users[1][1]])); ?>"><?php echo e($pair_users[1][0]); ?></a>
            <?php endif; ?>
             upvoted on the comment "<?php echo e($notification_specifics[1]->comment->content); ?>" from your article</p>
            
             <button type="button" class="small-rectangle" onclick="window.location.href='<?php echo e(route('showArticle', ['id' => $notification_specifics[1]->comment->article_id])); ?>'">
                <i class='bx bx-show remove-position' ></i>
                View Comment
            </button>    
        <?php elseif($notification_specifics[0] === 5): ?>
            <div class="profile-info">
            <p><i class='bx bx-comment'></i>
            <?php if($pair_users[1][0] === $user->display_name): ?>
                <a href="<?php echo e(route('profile', ['username' => $pair_users[1][1]])); ?>">You</a>
            <?php else: ?>
                <a href="<?php echo e(route('profile', ['username' => $pair_users[1][1]])); ?>"><?php echo e($pair_users[1][0]); ?></a>
            <?php endif; ?>
             upvoted on the reply "<?php echo e($notification_specifics[1]->reply->content); ?>" from your article</p>
            
            <button type="button" class="small-rectangle" onclick="window.location.href='<?php echo e(route('showArticle', ['id' => $notification_specifics[1]->reply->comment->article_id])); ?>'">
                <i class='bx bx-show remove-position' ></i>
                View Reply
            </button>
        <?php endif; ?>

        <?php if(!$notification->is_viewed): ?>
            <button type="button" class="small-rectangle" data-notification-id="<?php echo e($notification->id); ?>" id="archive-button">
                <i class='bx bx-archive-in remove-position'></i>Archive
            </button>
        <?php endif; ?>
        </div>
        <p class="small-text date"><?php echo e($notification->ntf_date); ?></p>
    </div>
<?php endif; ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/notification_card.blade.php ENDPATH**/ ?>