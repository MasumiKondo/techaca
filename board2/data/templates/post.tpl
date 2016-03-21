
{if isset($errorMessage)}<!-- エラーがあるときに表示する -->

    <div class="errormsg">
        {foreach $errorMessage as $errors}
            {$errors}<br>
        {/foreach}
    </div>

{/if}

{if $params.isSuccess != true }<!-- 処理が終わってないとき -->

    <form method="POST" action="post.php">
        <dl>
            <dt>投稿者：</dt>
            <dd><input type="text" name="nickname" value="{$params.nickname|escape:'html':'UTF-8'}"></dd>
            <dt>内容：</dt>
            <dd><textarea name="comment" rows="8" cols="40">{$params.comment|escape:'html':'UTF-8'|nl2br}</textarea></dd>
        </dl>
        <p class="btn"><button type="submit" name="btn1">投稿する</button></p>
    </form>

{else}<!-- 処理が終わったら -->

    <div class="message">
        <p>以下内容が投稿されました</p>
    </div>
    <p class="nickname">投稿者:{$params.nickname|escape:'html':'UTF-8'}</p>
    <div class="comment">{$params.comment|escape:'html':'UTF-8'|nl2br}</div>
    <p class="postdate">{$params.postDate|escape:'html':'UTF-8'}</p>
    <form method="GET" action="post.php">
        <p class="btn"><button type="submit" name="btn1">投稿画面へ</button></p>
    </form>
    <form method="GET" action="index.php">
        <p class="btn"><button type="submit" name="btn2">一覧画面へ</button></p>
    </form>

{/if}
