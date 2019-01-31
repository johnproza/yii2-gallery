import React,{Component} from "react";
import Item from "./item";

export default class Child extends Component {

    constructor(props) {
        super(props);
        this.state = {
            data : this.props.data,
            showForm : this.props.form,
            totalShow : 3,
            showMore: true
        }
    }

    render() {
        var count = this.props.data.length - 3;
        if(count<=0) {count = null}
        return (

            <div>
                {this.props.data.map((child,j)=>
                this.state.totalShow > j ?
                    <Item data={child}
                          userCan={this.props.userCan}
                          message={this.props.message}
                          submit = {this.props.submit}
                          vote={this.props.vote}
                          form = {false}
                          classElem={'itemComment child'}
                          key={child.id}
                          update={this.props.update} />:null

                )}
                {this.state.showMore && this.state.data.length >3 ? <div onClick={this.dataToggle} className={'showAllChild'}>Показать еще {count}</div> : null}
            </div>

        )
    }

    dataToggle = () =>{
        this.setState(()=> {
            return {totalShow:this.props.data.length,
                    showMore : false}
        })
    }

}