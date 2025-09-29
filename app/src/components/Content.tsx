import React from 'react'

export default function Content (props) {
    return <div id="page-top">
        <div id="wrapper">
                <div id="content-wrapper" className="d-flex flex-column">
                    <div id="content">
                        <div className="container-fluid">
                            {props.content}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
}
