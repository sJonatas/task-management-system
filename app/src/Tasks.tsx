import { useEffect, useState } from "react";
import Nav from "./components/Nav";
import client from "./http/client";
import Content from "./components/Content";
import Paginator from "./components/Paginator";
import type { Task } from "./interfaces/task.interface";

import ModalCreate from "./components/ModalCreate";
import ModalUpdate from "./components/ModalUpdate";

export default function Tasks() {
    const [page, setPage] = useState(1)
    const [filter, setFilter] = useState('');
    const [links, setLinks] = useState([]);
    const [tasks, setTasks] = useState([])
    const [state, setState] = useState(0);
    const [loading, setLoading] = useState(true)
    const [showCreate, setShowCreate] = useState(false);
    const [showUpdate, setShowUpdate] = useState(false);

    const closeCreateModal = () => setShowCreate(false);
    const closeUpdateModal = () => setShowUpdate(false);
    const [currentTaskId, setCurrentTaskId] = useState(0);

    useEffect(() => {
        setLoading(true)
        client.getAllTasks(page, filter, response => {
            if (response.status !== 200) {
                alert(response.error);

                return;
            }
            setTasks(response.response.data);
            setLinks(response.response.links);
            setLoading(false)
        })
    }, [tasks.length === 0, state, page]);

    const deleteTask = (taskId: number) => {
        if (! confirm('Are you sure you want to delete this Task?')) {
            return;
        }

        client.deletetask(taskId, response => {
            if (response.status === 204) {
                alert('The task was successfully deleted.');

                setState(state+taskId);
                return;
            }

            alert(response.response.data.error);
            setState(state+taskId);
        })
    } 

    function Tasks() {
        return tasks.map((task: Task) => {
            return <tbody>
                <tr>
                    <td>{task.title}</td>
                    <td>{task.description}</td>
                    <td>{task.status}</td>
                    <td>{task.priority}</td>
                    <td>{task.dueDate!}</td>
                    <td>{task.created_at!}</td>
                    <td>{task.updated_at!}</td>
                    <td>
                        <button type="button" className="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm" onClick={() => {
                            setCurrentTaskId(task.id!);
                            setShowUpdate(true)}
                            }>
                            Update
                        </button>
                    </td>
                    <td>
                        <button type="button" className="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onClick={() => deleteTask(task.id)}>
                            -
                        </button>
                    </td>
                </tr>
            </tbody>
        })
    }

    return <>
        {
            loading ?
                <>Loading...</>

                :
            <Content content={
                <div className="table-responsive">
                    <ModalCreate closeModal={closeCreateModal} show={showCreate} setState={setState}/>
                    <ModalUpdate closeModal={closeUpdateModal} show={showUpdate} taskId={currentTaskId} setState={setState}/>
                    <div className="dataTables_wrapper dt-bootstrap4" id="dataTable_wrapper">
                        <Nav />
                        
                        
                        <div className="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 className="h3 mb-0 text-gray-800">Tasks</h1>
                            <button type="button" className="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onClick={() => setShowCreate(true)}>
                                New +
                            </button>
                        </div>
                        
                        <table className="table table-bordered dataTable bg-white" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Due Date</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            
                            <Tasks />
                        </table>

                        <Paginator links={links} setPage={setPage} />
                        </div>
                        </div>
                    }
                    />
        }
    </>
}