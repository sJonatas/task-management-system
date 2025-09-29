
import { useState } from 'react';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import client from '../http/client';

function ModalCreate(props) {
  const [task, setTask] = useState({
    title: '',
    description: '',
    status: 'pending',
    priority: 'medium',
    dueDate: null,
  });

  const [errors, setErrors] = useState('');
  const [loading, setLoading] = useState(false);

  const submit = () => {
    client.createTask(task, response => {
      
      setLoading(true);

      if (response.status === 201) {
        alert('The task was sucessfully created');
        
        props.setState(response.data.task.id);
        setErrors('')
        setTask({
          title: '',
          description: '',
          status: 'pending',
          priority: 'medium',
          dueDate: null,
        });
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
          <Modal.Title> New Task </Modal.Title>
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
            <option value='pending'>Pending</option>
            <option value='in_progress'>In Progress</option>
            <option value='completed'>Completed</option>
          </select>

          <br/>
          Priority 
          <select className="form-control" onChange={e => {
            setTask({...task, priority: e.target.value})
          }}>
            <option value='low'>Low</option>
            <option value='medium'>Medium</option>
            <option value='high'>High</option>
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

export default ModalCreate;