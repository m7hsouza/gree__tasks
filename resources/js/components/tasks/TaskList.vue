<template>
  <v-card class="mx-auto" max-width="700">
    <v-overlay v-if="!userId" :value="showOverlay">
      <v-alert border="top" color="#fb8c00" colored-border type="warning">
        É necessário está logado para realizar essa ação
        <span style="margin-right: 16px;"></span>
        <v-btn fab x-small color="#fb8c00" @click="showOverlay = false">
          <v-icon x-small>mdi-close</v-icon>
        </v-btn>
      </v-alert>

    </v-overlay>
    <add-task-form :onSave="saveTask" :onClose="closeAddTaskForm" :dialog="showAddTaskForm" />
    <edit-task-form :onSave="updateTask" v-if="taskSelected" :task="taskSelected"
      :onClose="() => {showEditTaskForm = false; taskSelected = null}" :dialog="showEditTaskForm" />
    <delete-task-dialog :onDelete="deleteTask" :onCancel="() => { deleteTaskDialog = false; deleteTaskId = null }" :dialog="deleteTaskDialog" />
    <div class="card-header">
      <v-card-title>Lista de tarefas</v-card-title>
      <button @click="handlerCheckIsAuth(() => showAddTaskForm = true)">
        Nova tarefa
        <v-icon color="#FFF">
          mdi-plus
        </v-icon>
      </button>
    </div>

    <v-list class="mx-auto" two-line max-width="600">
      <template v-for="({ assignee, stage, ...task }) in tasks">
        <v-list-item>
          <v-list-item-avatar size="50">
            <v-img v-if="assignee.img" :src="assignee.img"></v-img>
            <v-img v-else :src="`https://ui-avatars.com/api/?color=FFF&background=0654a3&name=${assignee.name}`">
            </v-img>
          </v-list-item-avatar>
          <span class="margin-user-avatar"></span>
          <v-list-item-content>
            <v-list-item-title v-html="task.title" />
            <v-list-item-subtitle>
              <small>
                <strong> Criado por: </strong><span class="assignee">{{ assignee.name }}</span>
              </small>             
            </v-list-item-subtitle>
            <v-list-item-subtitle>
              <v-chip outlined x-small :color="stage.color" v-html="stage.name" />
            </v-list-item-subtitle>
          </v-list-item-content>
          <v-list-item-action>
            <div class="progress-wrapper">
              <v-progress-circular :rotate="-90" color="#000000" width="3" size="35" :value="task.progress">
                <!-- <span class="progress-value">
                  {{ task.progress }}%
                </span> -->
                <v-list-item-action-text>{{ task.progress }}%</v-list-item-action-text>
              </v-progress-circular>
              <v-list-item-action-text>Progresso</v-list-item-action-text>
              <!-- <span class="progress-label">Progress</span> -->
            </div>
          </v-list-item-action>
          <div class="icons-wrapper">
            <v-icon @click="handlerEditTask({ ...task, stage, assignee })">mdi-pencil</v-icon>
            <v-icon @click="showDeleteTaskDialog(task.id)">mdi-delete</v-icon>
          </div>
        </v-list-item>
        <v-divider />
      </template>
    </v-list>
  </v-card>
</template>


<script>
export default {
  props: {
    userId: String
  },
  mounted() {
    this.loadTasks()
  },
  data: () => ({
    taskSelected: null,
    deleteTaskId: null,
    showOverlay: false,
    showAddTaskForm: false,
    showEditTaskForm: false,
    deleteTaskDialog: false,
    tasks: []
  }),
  methods: {
    showDeleteTaskDialog(taskId) {
      this.handlerCheckIsAuth(() => this.deleteTaskDialog = true)
      this.deleteTaskId = taskId;
    },
    handlerCheckIsAuth(showForm) {
      if (this.userId) {
        showForm()
      } else {
        this.showOverlay = true
      }
    },
    handlerEditTask(task) {
      this.handlerCheckIsAuth(() => this.showEditTaskForm = true)
      this.taskSelected = task
    },
    closeAddTaskForm() {
      this.showAddTaskForm = false
    },
    async loadTasks() {
      var { data } = await axios.get('/tasks-with-assignee')

      this.tasks = data;
    },
    async saveTask(title) {
      this.closeAddTaskForm()

      var { data: newTask } = await axios.post('/task', { title })
      this.tasks.push(newTask)
    },
    async updateTask({ id, title, stage, progress }) {
      this.showEditTaskForm = false
      const { data: updatedTask } = await axios.put(`/task/${id}`, {
        title,
        progress,
        stageId: stage.id
      })
      var foundIndex = this.tasks.findIndex(task => task.id == id)
      this.tasks.splice(foundIndex, 1, updatedTask);
      this.taskSelected = null;
    },
    async deleteTask() {
      this.deleteTaskDialog = false
      
      const { data: { isDeleted } } = await axios.delete(`/task/${this.deleteTaskId}`)

      if(isDeleted) {
        this.loadTasks()
      }

    }
  }
}
</script>


<style lang="scss">
.card-header {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;

  button {
    font-weight: bolder;
    border: 2px solid #FFF;
    border-radius: 4px;
    padding: 4px 16px;

    opacity: 0.8;

    -webkit-transition: opacity 0.2s ease-in-out;
    -moz-transition: opacity 0.2s ease-in-out;
    -ms-transition: opacity 0.2s ease-in-out;
    -o-transition: opacity 0.2s ease-in-out;
    transition: opacity 0.2s ease-in-out;

    &:hover {
      zoom: 1;
      // filter: alpha(opacity=50);
      opacity: 1;
    }
  }

  .v-card__title {
    padding: 0;
    font-weight: bolder;
  }
}

.margin-user-avatar {
  margin-right: 16px;
}

.progress-wrapper {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;

  font-weight: bold;
  font-size: 0.85rem;

  .progress-value {
    text-align: center;
    font-size: 0.75rem;
    color: #5a5a5a;
  }

  .progress-label {
    color: #858585;
  }
}

.v-list {
  height: 350px;
  overflow-y: auto
}

.v-list-item {
  min-height: 40px;
  height: 40px;

  .v-list-item__title {
    font-size: 1.2rem;
  }

  .assignee {
    font-style: italic;
  }

  .v-avatar,
  .v-list-item__content {
    margin: 0;
    padding: 0;
  }

}

hr.v-divider {
  margin-top: 0.4rem;
  margin-bottom: 0.4rem;
}

.icons-wrapper {
  display: flex;
  justify-content: space-between;
  width: 5rem;
  margin-left: 1.4rem;
}
</style>