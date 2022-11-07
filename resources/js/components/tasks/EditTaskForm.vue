<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">Edit task</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  :error="!!error_message"
                  :error-messages="error_message"
                  v-model="task.title"
                  label="Title*"
                  @blur="formValidate"
                  counter
                  maxlength="255"
                >
                  <template v-slot:label>
                    <div>
                      <small color="#FF0000" >
                        Titulo <small>(obrigatório)</small>
                      </small>
                    </div>
                  </template>
                  <template v-slot:message="{message}">
                    <div class="error-message">{{message}}</div>
                  </template>
                </v-text-field>
              </v-col>
              <v-col cols="10">
                <v-text-field readonly v-model="task.assignee.name" label="Usuário" prepend-icon="mdi-account">
                </v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field v-model="task.formatted_created_at" label="Criado em" prepend-icon="mdi-calendar"
                  readonly></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-autocomplete :items="stages" item-text="name" :value="task.stage" label="Status" return-object dense
                  chips small-chips @change="onChange"></v-autocomplete>
              </v-col>
              <v-col cols="6">
                <v-slider color="#0654a3" :label="`Progresso (${task.progress}%)`" v-model="task.progress" step="1"
                  :min="0" max="100" thumb-label ticks></v-slider>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="#4C5B68" outlined text @click="onClose">
            Cancelar
          </v-btn>
          <div style="margin-right: 16px"></div>
          <v-btn color="#1159A2" dark @click="handlerOnSave">
            Atualizar
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
    onSave: Function,
    task: {}
  },
  data: () => ({
    error_message: undefined,
    stages: [
      { id: 1, name: 'to-do', color: '#53BCF3' },
      { id: 2, name: 'in-progress', color: '#FD9E3E' },
      { id: 3, name: 'done', color: '#4ECA6F' }
    ]
  }),
  methods: {
    formValidate() {
      this.error_message = undefined
      var titleLength = this.task.title.length
      console.log(titleLength)
      if (!this.task.title) {
        this.error_message = 'O titulo é obrigatório'
        return
      }
      if(titleLength < 10) {
        this.error_message = 'O titulo deve conter no mínimo 10 caracteres'
        return
      }
      if(titleLength > 255) {
        this.error_message = 'Tamanho máximo para o titulo é de 255 caracteres';
        return
      }
    },
    onChange(stage) {
      this.task.stage = stage
    },
    handlerOnSave() {
      this.formValidate()

      if (!this.error_message) {
        this.onSave(this.task)
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
