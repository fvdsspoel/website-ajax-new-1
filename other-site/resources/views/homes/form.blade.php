<div class="card">
    <div class="card-header">
        <h5><strong>Banners</strong></h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row pl-3 pr-3">

                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div class="col-md-12 image-div">
                            <label title="Click for change image" style="cursor: pointer;width: 100%">
                                <img id="preview-1" src="{{$data->about_image ?? ''}}" onerror="this.src='/assets/images/default/up-img-1.png'" alt="your image" width="250px;" height="150px;" class="image-preview" />
                                <input type="file" name="about_image" style="display: none;" id="multi-selected-1"  autocomplete="off"  onchange="readURL(this,1);"  required readonly>
                            </label>
                            <input type="hidden" id="multi-selected-id-1" name="multi_selected_aboutimage" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                            <p class="text-center image-label" style="font-size: 15px;">Upload Mission Banner Here</p>
                        </div> 
                    </div>

                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div class="col-md-12 image-div">
                            <label title="Click for change image" style="cursor: pointer;width: 100%">
                                <img id="preview-2" src="{{$data->logo ?? ''}}" onerror="this.src='/assets/images/default/up-img-1.png'" alt="your image" width="250px;" height="150px;" class="image-preview" />
                                <input type="file" name="logo" style="display: none;" id="multi-selected-2"  autocomplete="off"  onchange="readURL(this,2);"  required readonly>
                            </label>
                            <input type="hidden" id="multi-selected-id-2" name="multi_selected_logo_image" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                            <p class="text-center image-label" style="font-size: 15px;">Upload Logo Here</p>
                        </div> 
                    </div>

                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div class="col-md-12 image-div">
                            <label title="Click for change image" style="cursor: pointer;width: 100%">
                                <img id="preview-3" src="{{$data->icon ?? ''}}" onerror="this.src='/assets/images/default/up-img-1.png'" alt="your image" width="250px;" height="150px;" class="image-preview" />
                                <input type="file" name="icon" style="display: none;" id="multi-selected-3"  autocomplete="off"  onchange="readURL(this,3);"  required readonly>
                            </label>
                            <input type="hidden" id="multi-selected-id-3" name="multi_selected_icon_image" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                            <p class="text-center image-label" style="font-size: 15px;">Upload Icon Here</p>
                        </div> 
                    </div>

                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div class="col-md-12 image-div">
                            <label title="Click for change image" style="cursor: pointer;width: 100%">
                                <img id="preview-4" src="{{$data->home_banner ?? ''}}" onerror="this.src='/assets/images/default/up-img-1.png'" alt="your image" width="250px;" height="150px;" class="image-preview" />
                                <input type="file" name="home_banner" style="display: none;" id="multi-selected-4"  autocomplete="off"  onchange="readURL(this,4);"  required readonly>
                            </label>
                            <input type="hidden" id="multi-selected-id-4" name="multi_selected_home" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                            <p class="text-center image-label" style="font-size: 15px;">Upload Home Banner Here</p>
                        </div> 
                    </div>

                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div class="col-md-12 image-div">
                            <label title="Click for change image" style="cursor: pointer;width: 100%">
                                <img id="preview-5" src="{{$data->home_mobile_banner ?? ''}}" onerror="this.src='/assets/images/default/up-img-1.png'" alt="your image" width="250px;" height="150px;" class="image-preview" />
                                <input type="file" name="home_mobile_banner" style="display: none;" id="multi-selected-5"  autocomplete="off"  onchange="readURL(this,5);"  required readonly>
                            </label>
                            <input type="hidden" id="multi-selected-id-5" name="multi_selected_home_mobile" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                            <p class="text-center image-label" style="font-size: 15px;">Upload Home Mobile Here</p>
                        </div> 
                    </div>

                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div class="col-md-12 image-div">
                            <label title="Click for change image" style="cursor: pointer;width: 100%">
                                <img id="preview-6" src="{{$data->contact_banner ?? ''}}" onerror="this.src='/assets/images/default/up-img-1.png'" alt="your image" width="250px;" height="150px;" class="image-preview" />
                                <input type="file" name="contact_banner" style="display: none;" id="multi-selected-6"  autocomplete="off"  onchange="readURL(this,6);"  required readonly>
                            </label>
                            <input type="hidden" id="multi-selected-id-6" name="multi_selected_contact" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                            <p class="text-center image-label" style="font-size: 15px;">Upload Contact Us Banner Here</p>
                        </div> 
                    </div>

                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div class="col-md-12 image-div">
                            <label title="Click for change image" style="cursor: pointer;width: 100%">
                                <img id="preview-7" src="{{$data->contact_mobile_banner ?? ''}}" onerror="this.src='/assets/images/default/up-img-1.png'" alt="your image" width="250px;" height="150px;" class="image-preview" />
                                <input type="file" name="contact_mobile_banner" style="display: none;" id="multi-selected-7"  autocomplete="off"  onchange="readURL(this,7);"  required readonly>
                            </label>
                            <input type="hidden" id="multi-selected-id-7" name="multi_selected_contact_mobile" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                            <p class="text-center image-label" style="font-size: 15px;">Upload Contact Us Mobile Here</p>
                        </div> 
                    </div>

                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div class="col-md-12 image-div">
                            <label title="Click for change image" style="cursor: pointer;width: 100%">
                                <img id="preview-8" src="{{$data->about_banner ?? ''}}" onerror="this.src='/assets/images/default/up-img-1.png'" alt="your image" width="250px;" height="150px;" class="image-preview" />
                                <input type="file" name="about_banner" style="display: none;" id="multi-selected-8"  autocomplete="off"  onchange="readURL(this,8);"  required readonly>
                            </label>
                            <input type="hidden" id="multi-selected-id-8" name="multi_selected_about" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                            <p class="text-center image-label" style="font-size: 15px;">Upload About Us Banner Here</p>
                        </div> 
                    </div>

                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div class="col-md-12 image-div">
                            <label title="Click for change image" style="cursor: pointer;width: 100%">
                                <img id="preview-9" src="{{$data->about_mobile_banner ?? ''}}" onerror="this.src='/assets/images/default/up-img-1.png'" alt="your image" width="250px;" height="150px;" class="image-preview" />
                                <input type="file" name="about_mobile_banner" style="display: none;" id="multi-selected-9"  autocomplete="off"  onchange="readURL(this,9);"  required readonly>
                            </label>
                            <input type="hidden" id="multi-selected-id-9" name="multi_selected_about_mobile" value="old"  class="form-control input-sm style_input"  autocomplete="off"  />
                            <p class="text-center image-label" style="font-size: 15px;">Upload About Us Mobile Here</p>
                        </div> 
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5><strong>About The Company</strong></h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row pl-3 pr-3">

                    <div class="col-md-4 p-3">
                        <label>Home Title</label>
                        <input type="text" name="home_title" class="form-control" required  placeholder="Insert Title" value="{{$data->home_title ?? ''}}">
                    </div>
                    <div class="col-md-4 p-3">
                        <label>Contact Us Title</label>
                        <input type="text" name="contact_title" class="form-control" required  placeholder="Insert Title" value="{{$data->contact_title ?? ''}}">
                    </div>
                    <div class="col-md-4 p-3">
                        <label>Our Story Title</label>
                        <input type="text" name="about_title" class="form-control" required  placeholder="Insert Title" value="{{$data->about_title ?? ''}}">
                    </div>

                    <div class="col-md-4 p-3">
                        <label>Corporate Number</label>
                        <input type="text" name="corporate_no" class="form-control" required  placeholder="Insert Corporate Contact No" value="{{$data->corporate_no ?? ''}}">
                    </div>
                    <div class="col-md-4 p-3">
                        <label>Corporate Email</label>
                        <input type="text" name="corporate_email" class="form-control" required  placeholder="Insert Corporate Email Address" value="{{$data->corporate_email ?? ''}}">
                    </div>
                    <div class="col-md-4 p-3">
                        <label>Maps Link</label>
                        <input type="text" name="map_link" class="form-control" required  placeholder="Insert Map Link" value="{{$data->map_link ?? ''}}">
                    </div>

                    <div class="col-md-3 p-3">
                        <label>What is Sterk</label>
                        <input type="text" name="what_ajax" class="form-control" required  placeholder="Insert Ajax Description for Footer" value="{{$data->what_ajax ?? ''}}">
                    </div>
                    <div class="col-md-3 p-3">
                        <label>Contact No</label>
                        <input type="text" name="contact_no" class="form-control" required  placeholder="Insert Contact No" value="{{$data->contact_no ?? ''}}">
                    </div>
                    <div class="col-md-3 p-3">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" required  placeholder="Insert Email Address" value="{{$data->email ?? ''}}">
                    </div>
                    <div class="col-md-3 p-3">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" required  placeholder="Insert Company Location" value="{{$data->address ?? ''}}">
                    </div>

                    <div class="col-md-3 p-3">
                        <label>Fecebook Link</label>
                        <input type="text" name="fb" class="form-control" required  placeholder="Insert Social Media Link" value="{{$data->fb ?? ''}}">
                    </div>
                    <div class="col-md-3 p-3">
                        <label>Instagram</label>
                        <input type="text" name="intagram" class="form-control" required  placeholder="Insert Social Media Link" value="{{$data->intagram ?? ''}}">
                    </div>
                    <div class="col-md-3 p-3">
                        <label>Twitter</label>
                        <input type="text" name="twitter" class="form-control" required  placeholder="Insert Social Media Link" value="{{$data->twitter ?? ''}}">
                    </div>
                    <div class="col-md-3 p-3">
                        <label>Youtube</label>
                        <input type="text" name="yt" class="form-control" required  placeholder="Insert Social Media Link" value="{{$data->yt ?? ''}}">
                    </div>

                    <div class="col-md-12 p-3">
                        @include('layouts.editor')
                        <input type="hidden" name="about_detail" id="about-detail" class="form-control " required  placeholder="Insert Detail" value="{{$data->about_detail ?? ''}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="right">
    <button class="btn btn-success" value="{{Auth::user()->id ?? ''}}" id="eid"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
    <button class="btn btn-danger" type="button" id="reset_btn"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
</div>
<input type="hidden" name="current_user" id="current-user" class="form-control " required value="{{Auth::user()->id}}">
<input type="hidden" name="id" id="id" class="form-control " required value="{{$data->id ?? ''}}">

