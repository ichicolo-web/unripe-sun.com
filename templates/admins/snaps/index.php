<form action="/admins/snaps" method="post" enctype="multipart/form-data">
  <table class="new">
    <tr>
      <td>モデル名</td>
      <td>
          <input type="text" name="name" value="">
      </td>
    </tr>

    <tr>
      <td>担当スタッフ名</td>
      <td>
        <select name="stuff">
          <option value="1">戸森</option>
          <option value="2">小池</option>
          <option value="3">吉野</option>
          <option value="4">榎本</option>
          <option value="5">佐久間</option>
          <option value="6">清水</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>性別</td>
      <td>
          <input type="radio" name="sex" value="1" checked="checked">女性
          <input type="radio" name="sex" value="0">男性
      </td>
    </tr>

    <tr>
      <td>画像</td>
      <td>
          <input type="file" name="file_path[]" multiple="multiple">
      </td>
    </tr>

    <tr>
      <td>カテゴリー</td>
      <td>
        <select name="category">
          <option value="0">ロング</option>
          <option value="1">セミロング</option>
          <option value="2">ミディアム</option>
          <option value="3">ボブ</option>
          <option value="4">ショート</option>
          <option value="5">ベリーショート</option>
          <option value="6">ヘアセット</option>
          <option value="7">カラーリング</option>
          <option value="8">パーマ</option>
        </select>
      </td>
    </tr>

    <tr>
      <td>メモ</td>
      <td>
        <textarea name="memo" rows="6" cols="60"></textarea>
      </td>
    </tr>

    <tr>
      <td class="buttons" colspan="2">
        <input type="hidden" name="_METHOD" value="POST">
        <input class="submit" type="submit" value="登録する">
        <input class="reset" type="reset" value="リセット">
      </td>
    </tr>
  </table>
</form>

<table class="results">
  <tr>
    <th>ID</th>
    <th>モデル名</th>
    <th>担当スタッフ名</th>
    <th>性別</th>
    <th>画像</th>
    <th>カテゴリー</th>
    <th>メモ</th>
    <th></th>
    <th></th>
  </tr>

  <? require(dirname(__FILE__) . '/../../partials/pagination.php'); ?>
  
  <? while ($result = $option[1]->fetchObject()): ?>
  <tr>
    <td><?= $result->id ?></td>
    <td><?= @$result->name ?></td>
    <td>
      <? if ($result->stuff == 1): ?>
        戸森
      <? elseif ($result->stuff == 2): ?>
        小池
      <? elseif ($result->stuff == 3): ?>
        吉野
      <? elseif ($result->stuff == 4): ?>
        榎本
      <? elseif ($result->stuff == 5): ?>
        佐久間
      <? elseif ($result->stuff == 6): ?>
        清水
      <? endif; ?>
    </td>
    <td>
    <? if($result->sex == 0): ?>
    男性
    <? else: ?>
    女性
    <? endif; ?>
    </td>
    <td><img src="/public/images/uploads/thumbnails/<?= @$result->file_path ?>"></td>

    <td>
    <? if($result->category == 0): ?>
    ロング
    <? elseif($result->category == 1): ?>
    セミロング
    <? elseif($result->category == 2): ?>
    ミディアム
    <? elseif($result->category == 3): ?>
    ボブ
    <? elseif($result->category == 4): ?>
    ショート
    <? elseif($result->category == 5): ?>
    ベリーショート
    <? elseif($result->category == 6): ?>
    ヘアセット
    <? elseif($result->category == 7): ?>
    カラーリング
    <? else: ?>
    パーマ
    <? endif; ?>
    </td>
    <td><?= nl2br(@$result->memo) ?></td>
    <td><?= $result->created_at ?></td>
    <td class="delete">
      <form action="/admins/snaps" class="update" method="post" onsubmit="return confirm('<?= @$result->name ?>さんを削除して宜しいですか？')">
        <input type="hidden" name="_METHOD" value="DELETE">
        <input type="hidden" name="id" value="<?= $result->id ?>">
        <input type="submit" value="削除する">
      </form>
    </td>
  </tr>
  <? endwhile; ?>
</table>
