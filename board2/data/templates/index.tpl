{if $count > 0}
    {foreach $params as $posts}
        <form action="edit.php" method="post">
        <p class="nickname">投稿者:{$posts.nickname|escape}[{$posts.id}]
            <button class="edit" type="submit">{$posts.id}を削除</button></p>
            <input type="hidden" name="id" value="{$posts.id}">
        <div class="comment">{$posts.comment|escape}</div>
        <p class="postdate">{$posts.postdate|escape}</p>
        </form>
    {/foreach}
{else}
    <p>まだ投稿されていません</p>
{/if}

<form method="GET" action="post.php">
    <p class="btn"><button type="submit" name="btn1">投稿画面へ</button></p>
</form>
