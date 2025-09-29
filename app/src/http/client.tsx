
import axios from 'axios';
import type { Task } from '../interfaces/task.interface';

const basepath = import.meta.env.VITE_API_BASEPATH;

async function getAllTasks(page: number = 1, filter: string = '', callback: any) {
    axios.get(`${basepath}/tasks?page=${page}&filter=${filter}`)
        .then((response) => {
            callback(response.data);
        })
        .catch(err => {
            callback(err)
        });
}

async function getStats(callback: any) {
    axios.get(`${basepath}/tasks/stats`)
        .then((response) => {
            callback(response.data);
        })
        .catch(err => {
            callback(err)
        });
}

async function createTask(task: Task, callback: any) {
    axios.post(`${basepath}/tasks`, task)
        .then((response) => {
            callback(response);
        })
        .catch(err => {
            callback(err);
        })
}

async function deletetask(taskId: number, callback: any) {
    axios.delete(`${basepath}/tasks/${taskId}`)
        .then((response) => {
            callback(response);
        })
        .catch(err => {
            callback(err);
        })
}

async function updateTask(task: Task, callback: any) {
    axios.patch(`${basepath}/tasks/${task.id}`, task)
        .then((response) => {
            callback(response);
        })
        .catch(err => {
            callback(err);
        })
}

async function getTask(taskId: number, callback: any) {
    axios.get(`${basepath}/tasks/${taskId}`)
        .then((response) => {
            callback(response);
        })
        .catch(err => {
            callback(err);
        })
}

export default {
    getAllTasks,
    getStats,
    createTask,
    deletetask,
    updateTask,
    getTask
}