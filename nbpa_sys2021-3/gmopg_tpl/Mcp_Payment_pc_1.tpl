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
		<h1>お支払手続き / Payment</h1>
	</div>

	<div class="flow">
		<ul>
			<li class="active">
				<a href="{$CancelURL|htmlspecialchars}">
					<span>ショッピングサイトに戻る  / Back to shopping site &gt;</span>
				</a>
			</li>
			{if $SelectURL ne null}
			<li  class="active">
				<a href="{$SelectURL|htmlspecialchars}">
					<span>お支払方法の選択 / Select payment method &gt;</span>
				</a>
			</li>
			{/if}
			<li  class="current">
				<span>必要事項を記入 / Enter payment information &gt;</span>
			</li>
			{if $Confirm eq '1'}
			<li>
				<span>確認して手続き / Confirm &gt;</span>
			</li>
			{/if}
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
							<span class="p">クレジットカード決済の必要事項をご記入ください。 / Please fill in the required information of the credit card payment.</span>
						</h2>
					</div>
				</div>

				<div class="bl_body">
					<table class="generic" summary="credit_1" id="credit">
						{if $MemberCardArray ne null}
							<tr>
								<th class="td_bl2">
									カードの指定方法を選択してください。 / Please choose the card payment mode.
								</th>
								<td>
									{insert name="radio_paymentMode"}
								</td>
							</tr>
							<tr>
								<th class="inner_label" colspan="2">
									カード番号を入力して決済する場合、以下の内容を入力してください。 / When enter the card number, please fill in the following.
								</th>
							</tr>
						{/if}
						<tr>
							<th>カード番号 / Card Number<br /><span class="note">ハイフン’-’無しで、数字のみご記入ください。 / please fill in the numbers only.</span></th>
							<td><input name="CardNo" type="text" id="Name" value="{$CardNo|htmlspecialchars}" class="code" maxlength="16" size="20"/></td>
						</tr>
						<tr>
							<th>有効期限(MM/YY) / Expiration Date(MM/YY)</th>
							<td>
								{insert name="select_expireList"}
							</td>
						</tr>
						<tr>
							<th>セキュリティコード / Security Code</th>
							<td><input name="SecurityCode" type="text" id="SecurityCode" value="{$SecurityCode|htmlspecialchars}" class="code" maxlength="4" size="6" /></td>
						</tr>
						{if $MemberCardArray ne null}
							<tr>
								<th class="inner_label" colspan="2">
									登録カードで決済する場合、以下の内容を入力してください。 / When choose a registered member card, please fill in the following.
								</th>
							</tr>
							<tr>
								<th class="td_bl2">ご利用になるカードを選択してください。/ Please choose the card for payment. </th>
								<td>{insert name="select_memberCardList"}</td>
							</tr>
						{/if}
					</table>
					<p class="control">
						<span class="submit">
							{if $Confirm eq "1"}
							<input type="submit" value="確認する / Confirm" />
							{else}
							<input type="submit" value="決済する / Pay" />
							{/if}
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
</div>
{* デバッグが必要な場合、以下の行の * を削除して、コメントを外してください。 *}
{*insert name="debug_showAllVars"*}
</body>
</html>