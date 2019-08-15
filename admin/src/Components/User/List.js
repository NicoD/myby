import React, { cloneElement } from 'react';
import { List, Datagrid, TextField, EmailField, ArrayField, SingleFieldList, ChipField } from 'react-admin';

export const StringToLabelObject = ({ record, children, ...rest }) =>
    cloneElement(children, {
        record: { label: record },
        ...rest
    }
)

export const UserList = (props) => (
    <List {...props} title="Users"  perPage={ 2 }>
        <Datagrid>
            <TextField source="originId" label="ID"/>
            <EmailField source="email" label="Email" />
            <ArrayField source="roleObjects" label="Role">
                <SingleFieldList>
                    <StringToLabelObject>
                        <ChipField source="label"/>
                    </StringToLabelObject>
                </SingleFieldList>
            </ArrayField>
        </Datagrid>
    </List>
);
