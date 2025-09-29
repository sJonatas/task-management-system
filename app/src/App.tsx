import { BrowserRouter, Routes, Route } from 'react-router-dom';

import './App.css'
import Dashboard from './Dashboard';
import Tasks from './Tasks';

function App() {

  return (<BrowserRouter>
        <Routes>
          <Route path="/" element={<Dashboard />} />
          <Route path="/tasks" element={<Tasks />} />
      </Routes>
    </BrowserRouter>)
}

export default App
