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
		<h1>お支払手続き / Receipt</h1>
	</div>

	<div class="flow">
		<ul>
			<li>
				<span>ショッピングサイトに戻る  / Back to shopping site &gt;</span>
			</li>
			{if $SelectURL ne null}
			<li>
				<span>お支払方法の選択 / Select payment method &gt;</span>
			</li>
			{/if}
			<li>
				<span>必要事項を記入 / Enter payment information &gt;</span>
			</li>
			{if $Confirm eq "1"}
			<li>
				<span>確認して手続き / Confirm &gt;</span>
			</li>
			{/if}
			<li class="current">
				<span>お支払手続き完了 / Complete</span>
			</li>
		</ul>
	</div>

	<div class="main">

		<form action="{$RetURL|htmlspecialchars}" method="post" onsubmit="return blockForm()">

			<p>{insert name="input_returnParams"}</p>

			<p class="txt">決済が完了しました。次へお進みください。 / Payment has been completed. Please press "Next".</p>

			<div class="block">
				<div class="bl_title">
					<div class="bl_title_inner">
						<h2>
							<span class="p">ご利用内容 / Payment Information</span>
						</h2>
					</div>
				</div>

				<div class="bl_body">

					<table class="generic">
					{if $JobCd != "CHECK" }
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
					  {/if}
					  <!--
					  <tr>
					    <th>:自由項目１名称:</th>
					    <td >{$ClientField1|htmlspecialchars}</td>
					  </tr>
					  <tr>
					    <th>:自由項目２名称:</th>
					    <td >{$ClientField2|htmlspecialchars}</td>
					  </tr>
					  <tr>
					    <th>:自由項目３名称:</th>
					    <td >{$ClientField3|htmlspecialchars}</td>
					  </tr>
					  -->
					  <tr>
					    <th>カード番号 / Card Number</th>
					    <td >{$CardNo|htmlspecialchars}</td>
					  </tr>
					  <tr>
					    <th>有効期限(MM/YY) / Expiration Date(MM/YY)</th>
					    <td >{$ExpireMonth|htmlspecialchars}/{$ExpireYear|htmlspecialchars}</td>
					  </tr>
					</table>

					<p class="control">
						<span class="submit">
							<input type="submit" value="進む / Next" />
						</span>
					</p>
					<br class="clear" />
				</div>

			</div>
		</form>
	</div>

</div>
</div>
{* デバッグが必要な場合、以下の行の * を削除して、コメントを外してください。 *}
{*insert name="debug_showAllVars"*}
</body>
</html>