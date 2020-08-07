<template>
    <div>
        <div class="block">
            <el-row v-loading="loading"
                    element-loading-text="Loading..."
                    element-loading-spinner="el-icon-loading"
                    element-loading-background="rgba(0, 0, 0, 0)"
                    class="form-horizontal form-bordered">
                <el-upload
                    action="#"
                    list-type="picture-card"
                    :file-list="fileList"
                    :on-change="handleChange"
                    multiple
                    :auto-upload="false">
                    <i slot="default" class="el-icon-plus" :title="lang.multi_upload"></i>
                    <div slot="file" slot-scope="{file}">
                        <img
                            class="el-upload-list__item-thumbnail"
                            :src="file.url" alt=""
                        >
                        <span class="el-upload-list__item-actions">
                        <span
                            class="el-upload-list__item-preview"
                            @click="handlePictureCardPreview(file)"
                        >
                      <i class="el-icon-zoom-in"></i>
                    </span>
                  </span>
                    </div>
                </el-upload>
                <el-dialog :visible.sync="dialogVisible">
                    <img width="100%" :src="dialogImageUrl" alt="">
                </el-dialog>

                <draggable tag="div" :list="form.images" handle=".handle">

                    <div class="padding-t col-md-4 col-sm-2" v-for="(element, idx) in form.images">

                        <div class="block">

                            <el-button
                                :title="lang.image_drag"
                                size="small"
                                type="info is-plain"
                                icon="el-icon-sort"
                                class="handle">
                            </el-button>

                            <el-button
                                @click="showEditImage(idx)"
                                :title="lang.image_edit"
                                size="small"
                                type="primary"
                                icon="el-icon-edit">
                            </el-button>

                            <el-button
                                @click="removeImage(idx)"
                                :title="lang.image_delete"
                                size="small"
                                type="danger"
                                icon="el-icon-delete">
                            </el-button>

                            <el-row :gutter="20">
                                <el-col :sm="24" :span="24" class="padding-tb">
                                    <div style="height: 200px; overflow: hidden;">
                                        <img :src="element.url" style="width: 100%;">
                                    </div>
                                    <span>{{ element[default_locale] ? element[default_locale].title  : ''}}</span>
                                </el-col>
                            </el-row>

                        </div>

                    </div>
                    <div style="clear: left;"></div>
                </draggable>

                <div class="padding-trl">
                    <div class="block padding-b">
                        <div class="col-12">
                            <el-button
                                type="primary is-plain"
                                size="small"
                                icon="el-icon-plus"
                                @click="showAdd(true)">
                                {{ lang.add_image }}
                            </el-button>
                        </div>
                    </div>
                </div>

                <AddImageComponent
                    v-if="showModal"
                    :updateImageData="updateImageData"
                    :lang="lang"
                    :upload_image_route="upload_image_route"
                    :locales="locales"
                    :default_locale="default_locale">
                </AddImageComponent>
            </el-row>
        </div>
    </div>
</template>

<style>
    .block .el-upload__input{
        display: none;
    }
</style>

<script>
    import {responseParse} from '../mixins/responseParse'
    import {getData} from '../mixins/getData'
    import draggable from "vuedraggable";
    import AddImageComponent from "./partials/AddImageComponent";
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import MyUploadAdapter from '../mixins/EditorCustomUpload';

    export default {
        components: {AddImageComponent, draggable},
        props: [
            'updateData',
            'lang',
            'upload_image_route',
            'locales',
            'default_locale',
            'module_name',
            'old_data',
            'options',
            'item',
            'editor_config'
        ],
        watch: {
            item() {

                if (this.item && this.item.galleries) {

                    this.locales.forEach((locale) => {

                        this.form.cover = this.item.galleries.fullFileUrl;
                        this.form.id = this.item.galleries.id;

                        let translationsData = this.getTranslationItem(this.item.galleries.translations, locale);

                        this.form[locale] = {
                            title: translationsData.title,
                            description: translationsData.description,
                        }

                    });

                    if (this.item.galleries.images) {

                        this.form.images = [];

                        this.item.galleries.images.forEach((image) => {

                            let pushData = {
                                id: image.id,
                                url: image.fullFileUrl
                            };

                            this.locales.forEach((locale) => {

                                let translationsData = this.getTranslationItem(image.translations, locale);

                                pushData[locale] = {
                                    title: translationsData.title,
                                }

                            });

                            this.form.images.push(pushData)

                        });

                    }

                }

            }
        },
        data() {
            return {
                activeTabName: 'ka',
                dialogVisible: false,
                loading: false,
                form: {
                    en: {},
                    ka: {},
                    images: []
                },
                editor: ClassicEditor,
                editorConfig: this.editor_config,
                showModal: false,

                dialogImageUrl: '',
                disabled: false,
                fileList: []
            }
        },
        created() {
            // Set upload plugin.
            this.editorConfig.extraPlugins = [this.meyCustomUploadAdapterPlugin];
        },
        updated() {
            this.updateData(this.module_name, this.form);
        },

        methods: {
            handleRemove(file) {
                this.fileList = this.fileList.filter(function(item){
                    return item.uid != file.uid;
                });
            },
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },

            async handleChange(file, fileList) {
                let fileItem = file.raw;

                var data = new FormData();
                data.append('file', fileItem);
                data.append('type', 'gallery_image');

                await getData({
                    method: 'POST',
                    url: this.upload_image_route,
                    data: data
                }).then(response => {
                    // Parse response notification.
                    responseParse(response);
                    if (response.code == 200) {
                        // Response data.
                        let data = response.data;

                        this.updateImageData({
                            image_id:   data.file.id,
                            url:        file.url,
                            ka: {},
                            en: {}
                        });
                    }
                    this.loading = false
                });

                this.fileList = [];
            },

            /**
             * Upload custom image in editor.
             */
            meyCustomUploadAdapterPlugin(editor) {

                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                    // Configure the URL to the upload script in your back-end here!
                    return new MyUploadAdapter(loader);
                };

            },

            /**
             * File upload.
             */
            async handleFileUpload() {

                let file = this.$refs.file[0].files[0];

                this.form = {...this.form, ...{cover: URL.createObjectURL(file)}};

                var data = new FormData();
                data.append('file', file);
                data.append('type', 'gallery_cover_image');

                await getData({
                    method: 'POST',
                    url: this.routes.upload_image,
                    data: data
                }).then(response => {

                    // Parse response notification.
                    responseParse(response);

                    if (response.code == 200) {

                        // Response data.
                        let data = response.data;

                        // Set image.
                        this.form.cover_image_id = data.image.id;

                    }

                    this.loading = false


                });

            },

            showAdd() {
                // this.$store.dispatch(types.GALLERY_EDIT_DATA, undefined);
                this.forceRerender(true);
            },

            showEditImage(index) {
                this.edit_data = '';
                this.form.images[index].index = index;
                let data = Object.assign({}, JSON.parse(JSON.stringify(this.form.images[index])));
                // this.$store.dispatch(types.GALLERY_EDIT_DATA, data);
                this.forceRerender(true);
            },

            removeImage(index) {

                this.$confirm(this.lang.remove_image_confirm, {
                    confirmButtonText: this.lang.remove_image_confirm_yes,
                    cancelButtonText: this.lang.remove_image_confirm_no,
                    type: 'warning'
                })
                    .then(async () => {
                        this.form.images = this.form.images.filter((item, i) => {
                            return i != index;
                        });
                    });
            },

            /**
             *
             * @param data
             */
            updateImageData(data = undefined, index = '') {

                if (data && index !== '') {
                    this.form.images[index] = data;
                } else if (data) {
                    this.form.images.push(data);
                } else {
                    let oldData = this.form.images;
                    this.form.images = {};
                    this.form.images = oldData;
                }
                // this.forceRerender();
            },

            forceRerender(showComponent = false) {
                // Remove my-component from the DOM
                this.showModal = !showComponent;
                this.$nextTick(() => {
                    // Add the component back in
                    this.showModal = showComponent;
                });
            },

            /**
             *
             * @param items
             * @param locale
             */
            getTranslationItem(items, locale) {

                let searchItem = {};

                items.forEach((item) => {
                    if (item.locale == locale) {
                        searchItem = item;
                    }
                })

                return searchItem;
            }

        }

    }

</script>
