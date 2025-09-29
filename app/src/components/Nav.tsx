import { Link } from "react-router-dom";

export default function Nav() {
    return <>
    <h1> Task Management </h1>
    
     <div className='container nav-menu bg-primary'>        
        <ul style={{listStyle: "none"}}>
            <li><Link to="/">Dashboard</Link></li>
            <li><Link to="/tasks">Tasks</Link></li>
        </ul>
    </div>
    </>
}
