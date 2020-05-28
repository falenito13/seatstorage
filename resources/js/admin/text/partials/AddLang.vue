<template>
    <span>
        <el-button
            icon="el-icon-circle-plus"
            style="margin-bottom: 2rem;"
            type="primary"
            @click="modal(true)">
            {{ trans_text.create }}
        </el-button>
        <el-drawer
            v-loading="loading"
            element-loading-text="Loading..."
            element-loading-spinner="el-icon-loading"
            element-loading-background="rgba(0, 0, 0, 0.8)"
            :title="trans_text.create"
            :visible.sync="dialogVisible"
            size="50%"
            direction="btt"
            custom-class="demo-drawer"
            ref="drawer"
            :before-close="handleClose">
          <div class="demo-drawer__content">

                <el-form :model="form">

                    <el-row>

                      <el-col :span="12">

                            <el-form-item :label="trans_text.key" :label-width="formLabelWidth">
                                <el-input :placeholder="trans_text.key" v-model="form.key"></el-input>
                            </el-form-item>

                        </el-col>

                       <el-col :span="12">

                            <el-form-item :label="trans_text.file_name" :label-width="formLabelWidth">
                                 <el-select filterable allow-create v-model="form.file" :placeholder="trans_text.file_name">
                                    <el-option
                                        v-for="(item,key) in groups"
                                        :key="key"
                                        :label="key"
                                        :value="key">
                                    </el-option>
                                  </el-select>
                            </el-form-item>

                        </el-col>

                        <template v-for="locale in locales">

                            <el-col :span="12">

                                <el-form-item :label="locale" :label-width="formLabelWidth">
                                    <el-input :placeholder="locale" v-model="form.text[locale]"></el-input>
                                </el-form-item>

                            </el-col>

                        </template>

                    </el-row>


                </el-form>

                <div class="demo-drawer__footer">
                  <el-button @click="modal(false)">{{ trans_text.cancel_text }}</el-button>
                  <el-button type="primary" @click="saveText" :disabled="loading" :loading="loading">{{ trans_text.save_text }}</el-button>
                </div>
          </div>
        </el-drawer>
    </span>
</template>

<style>
    .demo-drawer{
        overflow: scroll;
    }
</style>
<script>
    import {getData} from '../../../mixins/getData'
    import {responseParse} from '../../../mixins/responseParse'

    export default {

        props: [
            'trans_text',
            'routes',
            'groups',
            'locales',
            'getIndexBaseData'
        ],

        data(){
            return {
                loading: false,
                dialogVisible: false,
                form: {
                    file: '',
                    key: '',
                    text: {},
                },
                formLabelWidth: '200px'
            }
        },

        methods: {

            async saveText(){

                this.loading = true;

                await getData({
                    method: 'POST',
                    url: this.routes.store,
                    data: this.form
                }).then(response => {

                    // Parse response notification.
                    responseParse(response);

                    if (response.code == 200) {
                        this.getIndexBaseData();
                        this.modal(false);
                    }

                    this.loading = false;

                })

            },

            /**
             * Modal close/show
             */
            modal(status = true) {

                if (!status) {
                    this.clearInputs();
                }

                this.dialogVisible = status;
            },

            clearInputs() {
                this.form ={
                    file: '',
                    key: '',
                    text: {},
                }
            },

            /**
             *
             * @param done
             */
            handleClose(done) {
                this.clearInputs();
                done();
            },

        }

    }

</script>
