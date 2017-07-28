<div class="window message" style="width: 888px; z-index: 9005;">
        <div class="panel-header panel-header-noborder window-header" style="width: 888px;">
            <div class="panel-title">
                Message</div>
            <div class="panel-tool">
                <a class="panel-tool-close" onclick="javascript:close_popup()" href="javascript:void(0)">
                </a>
            </div>
        </div>
        <div id="chat" class="panel-body panel-body-noborder window-body">
            <div class="panel">
                <div class="dialog-content panel-body panel-body-noheader panel-body-noborder">
                    <div id="chat_dialog" class="easyui-layout layout">
                        <div class="panel layout-panel layout-panel-east">
                            <div class="panel-body panel-body-noheader layout-body">
                            </div>
                        </div>
                        <div class="panel layout-panel layout-panel-center">
                            <div region="center" title="" class="panel-body panel-body-noheader layout-body">
                                <div id="chat_dialog_main" class="easyui-layout layout">
                                    <div id="add_chat_comment_files" style="float: right; padding-right: 15px;">
                                        <div class="qq-uploader">
                                            <div class="qq-upload-drop-area" style="display: none;">
                                                <span>Drop files here to upload</span></div>
                                            <ul class="qq-upload-list">
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel layout-panel layout-panel-center" style="left: 0px; top: 0px; width: 724px;">
                                        <div id="chat_view_window" region="center" style="padding: 5px; width: 712px; height: 280px;" title="" class="panel-body panel-body-noheader layout-body">
                                            <div id="chat_view">
                                                <h1>
                                                    <span id="ContentPlaceHolder1_lblorder" style="color:Red;font-size:16px;"></span></h1>
                                                <input name="ctl00$ContentPlaceHolder1$hdn1" id="ContentPlaceHolder1_hdn1" type="hidden">
                                                <h2>
                                                    You can talk with this order participant
                                                    <div style="color: red;">
                                                        ATTENTION!</div>
                                                    <br>
                                                    <div style="color: red; font-size: 8pt; font-style: italic">
                                                        Do not use 
chargeback payment systems in your cooperation, like PayPal, Scrill 
etc.!</div>
                                                    <div style="font-size: 8pt;">
                                                        These systems 
allows the sender to call back the transfer and to so he can get the
                                                        money back! 
Fraudsters are often use such an option! Pay attention!</div>
                                                    <br>
                                                    <div style="color: rgb(255, 0, 0);">
                                                        <br>
                                                    </div>
                                                </h2>
                                                <div id="productfill">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel layout-panel-south">
                                        <div region="south" title="" class="panel-body panel-body-noheader layout-body" style="width: 722px">
                                            <div id="form_reply">
                                                <textarea name="ctl00$ContentPlaceHolder1$txtmsg" rows="2" cols="20" id="ContentPlaceHolder1_txtmsg" placeholder="Enter Message" style="height:100px;width:99%;"></textarea>
                                                <span id="ContentPlaceHolder1_req" style="color:Red;display:none;">*</span><br>
                                                <br>
                                                <table>
                                                    <tbody><tr>
                                                        <td width="50%">
                                                            <input name="ctl00$ContentPlaceHolder1$fileup" id="ContentPlaceHolder1_fileup" class="qq-upload-button" type="file">
                                                        </td>
                                                        <td width="30%">
                                                            <div id="imgfileup" style="width: 50px; height: 50px">
                                                            </div>
                                                        </td>
                                                        <td align="center">
                                                            <input name="ctl00$ContentPlaceHolder1$btnsubmit" value="Submit" onclick='javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions("ctl00$ContentPlaceHolder1$btnsubmit", "", true, "valid", "", false, false))' id="ContentPlaceHolder1_btnsubmit" class="success" type="submit">
                                                            <span id="ContentPlaceHolder1_lblmmesg"></span>
                                                        </td>
                                                    </tr>
                                                </tbody></table>
                                                <div class="clear">
                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layout-split-proxy-h">
                                    </div>
                                    <div class="layout-split-proxy-v">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="layout-split-proxy-h">
                        </div>
                        <div class="layout-split-proxy-v">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>