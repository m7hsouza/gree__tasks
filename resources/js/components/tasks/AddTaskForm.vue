<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card ref="form">
        <v-card-title>
          <span class="text-h5">Criar tarefa</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field :error="!!error_message" :error-messages="error_message" v-model="title" label="Titulo*" counter maxlength="255">
                  <template v-slot:label>
                    <div>
                      Titulo <small>(obrigatório)</small>
                    </div>
                  </template>
                  <template v-slot:message="{ message }">
                    <div class="error-message">{{message}}</div>
                  </template>
                </v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn 
            color="#4C5B68"
            text
            outlined
            @click="onClose"
          >
            Cancelar
          </v-btn>
          <div style="margin-right: 16px"></div>
          <v-btn 
            color="#1159A2"
            dark
            @click="handlerOnSave" 
            type="submit"
          >
            Salvar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>

export default {
  props: {
    dialog: Boolean,
    onClose: Function,
    onSave: Function
  },
  data() {
    return {
      title: '',
      error_message: '',
    }
  },
  methods: {
    formValidate() {
      this.error_message = undefined
      var titleLength = this.title.length
      if (!this.title) {
        return 'O titulo é obrigatório'
      }
      if(titleLength < 10) {
        return 'O titulo deve conter no mínimo 10 caracteres'
      }
      if(titleLength > 255) {
        return 'Tamanho máximo para o titulo é de 255 caracteres';
      }

      return undefined
    },
    handlerOnSave() {
      this.error_message = this.formValidate()

      if (!this.error_message) {
        this.onSave(this.title)
        this.title = '';
      }
    }
  }
}
</script>

<style lang="scss">

.error-message {
  color: red;
  font-style: italic;
}

</style>

