
import { useEffect, useState } from 'react';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import client from '../http/client';

function ModalUpdate(props) {
  const taskId = props.taskId;

  const [task, setTask] = useState({});

  const [errors, setErrors] = useState('');
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    if (props.show) {
      client.getTask(taskId, response => {
        if (response.status !== 200) {
          alert(response.response.data.error);

          props.closeModal();
        }

        setTask(response.data.task);
      })
    }
  }, [Object.keys(task).length === 0, props.show])

  const submit = () => {
    client.updateTask(task, response => {
      
      setLoading(true);

      if (response.status === 200) {
        alert('The task was sucessfully updated');
        
        props.setState(response.data.task.id);
        setErrors('')
        setLoading(false);
        props.closeModal();
      }
      else {
        setLoading(false);

        setErrors(response.response.data.error);
      }
    })
  }

  return (<>
    <div
      className="modal show"
      style={{ display: 'block', position: 'initial' }}
    >
      <Modal show={props.show} onHide={props.closeModal}>
        <Modal.Header closeButton>
          <Modal.Title> Update Task #{taskId}</Modal.Title>
        </Modal.Header>

        <Modal.Body>

        <div className='text-danger'>{errors}</div>
          {
            loading ? <>Loading...</>
            :
            <>
            Title
          <input type='text' className='form-control' value={task.title} onChange={e => {
            setTask({...task, title: e.target.value});
          }}
          />

          <br/>
          Description
          <textarea className='form-control' value={task.description} onChange={e => {
            setTask({...task, description: e.target.value});
          }}
          />

          <br/>
          Status 
          <select className="form-control" onChange={e => {
            setTask({...task, status: e.target.value})
          }}>
            <option value='pending' selected={task.status === 'pending'}>Pending</option>
            <option value='in_progress' selected={task.status === 'progress'}>In Progress</option>
            <option value='completed' selected={task.status === 'completed'}>Completed</option>
          </select>

          <br/>
          Priority 
          <select className="form-control" onChange={e => {
            setTask({...task, priority: e.target.value})
          }}>
            <option value='low' selected={task.priority === 'low'}>Low</option>
            <option value='medium' selected={task.priority === 'medium'}>Medium</option>
            <option value='high' selected={task.priority === 'high'}>High</option>
          </select>

          <br/>
          Due Date
          <input type='date' className='form-control' value={task.title} onChange={e => {
            setTask({...task, dueDate: e.target.value});
          }}
          />
            </>
          }
        </Modal.Body>

        <Modal.Footer>
          <Button variant="secondary" onClick={() => props.closeModal()}>Close</Button>
          <Button variant="primary" onClick={() => submit()}>Save changes</Button>
        </Modal.Footer>
      </Modal>
    </div>
  </>);
}

export default ModalUpdate;