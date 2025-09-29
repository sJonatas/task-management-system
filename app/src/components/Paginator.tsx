
interface Link {
    url: string|null,
    label: string|null,
    page: number|null,
    active: boolean
}

export default function Paginator(props) {
    return <>
        <div className="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
            <ul className="pagination">
                {
                    props.links.map((link: Link) => {
                        return <li className={'paginate_button page-item' + (link.active ? ' active' : '')}
                                    onClick={() => {
                                        if (link.url !== null) {
                                            props.setPage(link.page)
                                        }
                                    }}
                                >
                            {link.label}
                        </li>
                    })
                }
            </ul>
        </div>
    </>
}