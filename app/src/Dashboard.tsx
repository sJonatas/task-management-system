import { useEffect, useState } from 'react'
import './App.css'
import client from './http/client'
import Content from './components/Content'
import Nav from './components/Nav'

function Dashboard() {
  const [stats, setStats] = useState({})

  useEffect(() => {
    client.getStats((response: any) => {
      setStats(response.stats)
    })
  }, [Object.keys(stats).length === 0]);

  const getPercent = (qtt, total) => {
    return (parseInt(qtt)/parseInt(total)*100);
  }

  return (<>
      {
        Object.keys(stats).length === 0 
          ? 
          <>
            <div>
              Loading...
            </div>
          </>

          :
          <Content content={
            <>
            <Nav/>

            <div className="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 className="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>

            <div className="card mb-4 dashboard">
              <div className="card-header py-3">
                  <h6 className="m-0 font-weight-bold text-primary">Tasks</h6>
              </div>
              <div className="card-body">
                  <h4 className="small font-weight-bold">Total  <span
                          className="float-right">{stats.totalTasks}</span></h4>
                  <div className="progress mb-4">
                      <div className="progress-bar bg-danger" role="progressbar" style={{width: "100%"}}
                          aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 className="small font-weight-bold">Status: Pending <span
                          className="float-right">{stats.byStatus.pending}</span></h4>
                  <div className="progress mb-4">
                      <div className="progress-bar bg-warning" role="progressbar" style={{width: `${getPercent(stats.byStatus.pending, stats.totalTasks)}%`}}
                          aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 className="small font-weight-bold">Status: In Progress <span
                          className="float-right">{stats.byStatus.in_progress}</span></h4>
                  <div className="progress mb-4">
                      <div className="progress-bar" role="progressbar" style={{width: `${getPercent(stats.byStatus.in_progress, stats.totalTasks)}%`}}
                          aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 className="small font-weight-bold">Status: Completed <span
                          className="float-right">{stats.byStatus.completed}</span></h4>
                  <div className="progress mb-4">
                      <div className="progress-bar bg-info" role="progressbar" style={{width: `${getPercent(stats.byStatus.completed, stats.totalTasks)}%`}}
                          aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>

                  <h4 className="small font-weight-bold">Prioprity: Low <span
                          className="float-right">{stats.byPriority.low}</span></h4>
                  <div className="progress mb-4">
                      <div className="progress-bar bg-info" role="progressbar" style={{width: `${getPercent(stats.byPriority.low, stats.totalTasks)}%`}}
                          aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>

                  <h4 className="small font-weight-bold">Priority: Medium <span
                          className="float-right">{stats.byPriority.medium}</span></h4>
                  <div className="progress mb-4">
                      <div className="progress-bar bg-info" role="progressbar" style={{width: `${getPercent(stats.byPriority.medium, stats.totalTasks)}%`}}
                          aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>

                  <h4 className="small font-weight-bold">Priority: High <span
                          className="float-right">{stats.byPriority.high}</span></h4>
                  <div className="progress mb-4">
                      <div className="progress-bar bg-info" role="progressbar" style={{width: `${getPercent(stats.byPriority.high, stats.totalTasks)}%`}}
                          aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
              </div>
          </div>
          </>
          }/>
      }
      </>)
}

export default Dashboard
