
                            <form id="form-refill1"  method="post"<?= $this->url->get('money/recharge') ?> name="form-refill1">
                            <div class="recharge_num">
                                <span><b>您要充值金额：</b></span>&nbsp;
                                <input type="text" name="amount" style="height:32px; line-height:30px; border:1px solid #c8c8c8; width:140px; padding:0px 5px;" maxlength=8 /> &nbsp;
                                <span><b>算卦币</b></span> &nbsp; 注：充值的金额必须是整数,在线客服
                                <img  style="CURSOR: pointer;DISPLAY: inline-block; VERTICAL-ALIGN: middle" onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin=2532006145&site=qq&menu=yes', '_blank', 'height=502, width=544,toolbar=no,scrollbars=no,menubar=no,status=no');"
                                src=""  border="0" alt="点击这里和客服聊天">。
                            </div>

                            <div class="recharge_quick">
                                <div class="recharge_quick_01"><b>快捷支付：</b>无需网银！快速完成付款！</div>
                                <div style="padding-left:40px;" class="recharge_quick_02">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td><input name="zhifu" type="radio" value="alipay" checked="checked" /></td>
                                            <td><img src="<?= $site_url ?>img/bank/zhifu_icon01.jpg" alt="支付宝" /></td>
                                            <td><input name="zhifu" type="radio" value="tenpay" /></td>
                                            <td><img src="<?= $site_url ?>img/bank/zhifu_icon02.jpg" alt="财付通" /></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="recharge_send">
                                <a href="javascript:doRefill('form-refill1');">立即付款</a>
                            </div>
                            </form>