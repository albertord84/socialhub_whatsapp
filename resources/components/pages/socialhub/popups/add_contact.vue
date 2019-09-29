<template>
    <div>     
        <b-modal id="modalAddContact" :hide-footer="true" title="Novo contato">
            <b-container fluid>
                <p>Hola mundo</p>
                <!-- <div class="col-lg-12 sect_header">
                    <ul class="menu">
                        <li><a href="javascript:void(0)" @click.prevent="toggle_left"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
                        <li><p>Novo contato</p> </li>
                        <ul class="menu float-right">
                            <li ><a href="javascript:void(0)" @click.prevent="toggle_left()"><i class="fa fa-close"></i></a></li>
                        </ul>
                    </ul>
                </div>
                <form>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style="padding: 29px 0px 5px" class="form-group has-search">
                                    <span class="fa fa-user form-control-feedback"></span>
                                    <input v-model="new_first_name" id="name" name="username" type="text" autofocus placeholder="Nome ou Apelido" class="form-control"/>
                                </div>
                                <field-messages name="username" show="$invalid && $submitted" class="text-danger"></field-messages>
                            </validate>
                        </div>
                    </div>                
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style="" class="form-group has-search">
                                    <span class="fa fa-envelope form-control-feedback"></span>
                                    <input v-model="new_email" name="email" id="email" type="email" placeholder="E-mail" class="form-control"/>
                                </div>
                                <field-messages name="email" show="$invalid && $submitted" class="text-danger"><div slot="email">Email inválido</div></field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style="" class="form-group has-search">
                                    <span class="fa fa-phone form-control-feedback"></span>
                                    <input v-model="new_phone" id="fix_phone" name="fix_phone" type="text" placeholder="Telefone fixo" class="form-control"/>
                                </div>
                                <field-messages name="fix_phone" show="$invalid && $submitted" class="text-danger"></field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style="" class="form-group has-search">
                                    <span class="fa fa-whatsapp form-control-feedback"></span>
                                    <input v-model="new_whatsapp_id" id="whatsapp" name="whatsapp" type="text" required placeholder="WhatsApp (*)" class="form-control"/>
                                </div>
                                <field-messages name="whatsapp" show="$invali   d && $submitted" class="text-danger"><div slot="required">Whatssap é obrigatório</div></field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style="" class="form-group has-search">
                                    <span class="fa fa-facebook form-control-feedback"></span>
                                    <input v-model="new_facebook_id" id="facebook" name="facebook" type="text" placeholder="Facebook" class="form-control"/>
                                </div>
                                <field-messages name="facebook" show="$invalid && $submitted" class="text-danger"></field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style=" " class="form-group has-search">
                                    <span class="fa fa-instagram form-control-feedback"></span>
                                    <input v-model="new_instagram_id" id="instagram" name="instagram" type="text" placeholder="Instagram" class="form-control"/>
                                </div>
                                <field-messages name="instagram" show="$invalid && $submitted" class="text-danger">
                                </field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <div style="" class="form-group has-search">
                                    <span class="fa fa-linkedin form-control-feedback"></span>
                                    <input v-model="new_linkedin_id" id="linkedin" name="linkedin" type="text" placeholder="LinkedIn" class="form-control"/>
                                </div>
                                <field-messages name="linkedin" show="$invalid && $submitted" class="text-danger">
                                </field-messages>
                            </validate>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <validate tag="div">
                                <textarea v-model="model.decription" name="decription" id="decription" placeholder="Adicione descrição ..." class="form-control" cols="30" rows="5"></textarea>
                                <field-messages show="$invalid && $submitted" class="text-danger">
                                </field-messages>
                            </validate>
                        </div>
                    </div>

                    <div class="col-sm-12" v-show="show_error">
                        <ul>
                            <li v-for="error in validationErrors" class="text-danger">{{error[0]}}</li>
                        </ul>
                    </div>
                    <div class="col-sm-12" v-show="show_success">
                        <ul>
                            <li class="text-success">Your user record has been inserted successfully</li>
                        </ul>
                    </div>
                    <div class="col-lg-12 m-t-25 text-center">
                        <button type="submit" class="btn btn-primary btn_width">Adicionar</button>
                        <button type="reset" class="btn btn-effect-ripple btn-secondary btn_width reset_btn1" @click.prevent="form_reset();toggle_left()">Cancelar</button>
                    </div>
                </form> -->
                <!-- <form>
                    new_first_name: "",
                    new_last_name: "",
                    new_phone: "",
                    new_whatsapp_id: "",
                    new_facebook_id: "",
                    new_instagram_id: "",
                    new_linkedin_id: "",

                    <label for="matter_name" class="mt-2">Nome:</label>
                    <input type="text" id="matter_name_in" class="form-control" v-model="newmattername">

                    
                    <label for="matter_desc" class="mt-2">Descrição</label>
                    <textarea name="matter_desc_in" maxlength="500" class="form-control" rows="5" v-model="newmatterdesc"></textarea>
                    
                    <b-btn class="float-right mt-2" variant="primary" @click.prevent="addMatter">Adicionar</b-btn>
                    <span v-for="(error,key) in errors" v-bind:key="key" class="test-danger">{{error}}</span>
                </form> -->
            </b-container>
        </b-modal>
    </div>
</template>

<script>
    import Vue from "vue";
    import miniToastr from "mini-toastr";
    miniToastr.init();

    export default {
        name: "add_contact",

        data() {
            return {
                new_first_name: "",
                new_last_name: "",
                new_phone: "",
                new_email: "",
                new_description: "",
                new_remember: "",
                new_summary: "",
                new_whatsapp_id: "",
                new_facebook_id: "",
                new_instagram_id: "",
                new_linkedin_id: "",
            }
        },

        methods: {
            addContact: function() { //C                
                var url = "contacts";
                ApiService.post(url,{
                    'first_name': this.new_first_name,
                    'last_name': this.new_last_name,
                    'email': this.new_email,
                    'new_remember': this.new_remember,
                    'new_summary': this.new_summary,
                    'phone': this.new_phone,
                    'description': this.new_description,
                    'whatsapp_id': this.new_whatsapp_id,
                    'facebook_id': this.new_facebook_id,
                    'instagram_id': this.new_instagram_id,
                    'linkedin_id': this.new_linkedin_id,                    
                })
                .then(response => {
                    miniToastr.success("Contato adicionado com sucesso","Sucesso");
                    this.new_first_name = "";
                    this.new_last_name = "";
                    this.new_email = "";

                    this.new_remember = "";
                    this.new_summary = "";
                    this.new_phone = "";
                    this.new_description = "";

                    this.new_whatsapp_id = "";
                    this.new_facebook_id = "";
                    this.new_instagram_id = "";
                    this.new_linkedin_id = "";
                    this.reloadContacts();
                })
                .catch(function(error) {
                    ApiService.process_request_error(error); 
                    miniToastr.error(error, "Erro adicionando contato");  
                });
            },

            reloadContacts: function() { //R
                // disparar evento para que el padre recargue la página
            },
        },    

        created() {
            miniToastr.setIcon("error", "i", {class: "fa fa-times"});
            miniToastr.setIcon("warn", "i", {class: "fa fa-exclamation-triangle"});
            miniToastr.setIcon("info", "i", {class: "fa fa-info-circle"});
            miniToastr.setIcon("success", "i", {class: "fa fa-arrow-circle-o-down"});
        },

        computed: {
            
        },

        watch: {
           
        },
        
    }
</script>

<style scoped>
    
</style>
