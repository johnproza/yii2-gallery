import React,{Component} from "react";
import ReactDOM from 'react-dom';
import Item from './/item'

export default class Top extends Component {

    constructor(props) {
        super(props);
        console.log(this.props.data)
        this.state = {
            topId: this.props.topId,
            data:this.props.data,
            userCan:this.props.userCan,
            message:this.props.message
        }
    }

    render() {

        return (
            this.props.data!=null?
            <div className="topComment">

                <div className="parent" data-id={this.props.data.parent!=null ? this.props.data.parent.id : null} >
                    {this.props.data.parent!=null ?
                    <Item data={this.props.data.parent}
                          userCan={this.props.userCan}
                          message={this.props.message}
                          submit = {this.props.submit}
                          form = {false}
                          classElem={'itemComment parent'}
                          update={this.update} /> : null}
                    <div className={this.props.data.parent!=null ? "children best" : "best"} >
                         <Item data={this.props.data.top}
                          userCan={this.props.userCan}
                          message={this.props.message}
                          submit = {this.props.submit}
                          form = {false}
                          classElem={this.props.data.parent!=null ? "itemComment child" : "itemComment parentc"}
                          update={this.update} key={this.props.topId} />
                    </div>
                </div>
            </div>:null

        )

    }



}