<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-style-Type" content="text/html; charset=UTF-8" />
	<title>Nature's Best Photography Asia</title>

	<link href="{$CSSPATH}/common.css" rel="stylesheet" type="text/css" />

	{literal}
	<script type="text/javascript">
		var submitted = false
		function blockForm(){
			if( submitted ){
				return false
			}
			submitted = true
			return true
		}
	</script>
	{/literal}

</head>
<body>

<div class="wrapper">
<div class="bodyinner">

	<!--ヘッダー開始-->
	<div class="header">
		<h1>お支払手続き / Confirmation</h1>
	</div>

	<div class="flow">
		<ul>
			<li class="active">
				<a href="{$CancelURL|htmlspecialchars}">
					<span>ショッピングサイトに戻る &lt;</span>
				</a>
			</li>
			{if $SelectURL ne null}
			<li  class="active">
				<a href="{$SelectURL|htmlspecialchars}">
					<span>お支払方法の選択 / Select payment method &gt;</span>
				</a>
			</li>
			{/if}
			<li  class="active">
				<a href="{$EntryURL|htmlspecialchars}">
				<span>必要事項を記入 / Enter payment information &gt;</span>
				</a>
			</li>
			<li class="current">
				<span>確認して手続き / Confirm &gt;</span>
			</li>
			<li>
				<span>お支払手続き完了 / Complete</span>
			</li>
		</ul>
	</div>

	<div class="main">

		{if  $CheckMessageArray neq null }
		<div id="GP_msg">
			<ul>
			{foreach item=message from=$CheckMessageArray}
				<li>{$message}</li>
			{/foreach}
			</ul>
		</div>
		{/if}

		<form action="{$ExecURL|htmlspecialchars}" onsubmit="return blockForm()" method="post">

			<p>{insert name="input_keyItems"}</p>

			<div class="block">
				<div class="bl_title">
					<div class="bl_title_inner">
						<h2>
							<span class="p">下記の内容で決済します。よろしければ、「決済する」ボタンを押してください。 / Please confirm below and press "Pay".</span>
						</h2>
					</div>
				</div>

				<div class="bl_body">
					<table class="generic" summary="credit_1" id="credit">
						<tr>
							<th class="td_bl2">カード番号 / Card Number</th>
							<td>{$CardNo|htmlspecialchars}</td>
						</tr>
						<tr>
							<th class="td_bl2">カード有効期限(MM/YY) / Expiration Date(MM/YY)</th>
							<td>{$ExpireMonth|htmlspecialchars}/{$ExpireYear|htmlspecialchars}</td>
						</tr>
					</table>

					<p class="control">
						<span class="submit">
							<input type="submit" value="決済する / Pay" />
						</span>
					</p>
				</div>
			</div>

			<div class="block">
				<div class="bl_title">
					<div class="bl_title_inner">
						<h2>
							<span class="p">ご利用内容 / Payment Information</span>
						</h2>
					</div>
				</div>

				<div class="bl_body">

					<div>
						<table id="cartinfo" class="generic">
							<tr>
								<th>金額 / Amount</th>
								<td>{$Amount|htmlspecialchars} {$Currency|htmlspecialchars}</td>
							</tr>
							<tr>
								<th>税送料 / Tax & Shipping fee</th>
								<td>{$Tax|htmlspecialchars} {$Currency|htmlspecialchars}</td>
							</tr>
							<tr>
								<th>合計金額 / Total</th>
								<td>{$Total|htmlspecialchars} {$Currency|htmlspecialchars}</td>
							</tr>
						</table>
					</div>

				</div>

			</div>

			<br class="clear" />

		</form>
	</div>

</div>
{* デバッグが必要な場合、以下の行の * を削除して、コメントを外してください。 *}
{*insert name="debug_showAllVars"*}
</body>
</html>