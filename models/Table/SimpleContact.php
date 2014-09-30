<?php

/**
 * @package SimpleContact\models\Table
 */
class Table_SimpleContact extends Omeka_Db_Table
{
    /**
     * @param Omeka_Db_Select
     * @param array
     * @return void
     */
    public function applySearchFilters($select, $params)
    {
        $alias = $this->getTableAlias();
        $boolean = new Omeka_Filter_Boolean;
        foreach ($params as $key => $value) {
            if ($value === null || (is_string($value) && trim($value) == '')) {
                continue;
            }
            switch ($key) {
                case 'status':
                    switch ($value) {
                        case 'to_reply':
                            $select->where($alias . '.' . $key . ' = ?', 'received');
                            $select->where($alias . '.is_spam' . '!= ?', 1);
                            break;
                        default:
                            $select->where($alias . '.' . $key . ' = ?', $value);
                            break;
                    }
                    break;
                case 'user_id':
                    $this->filterByUser($select, $value, 'user_id');
                    break;
                case 'added':
                case 'added_since':
                    $this->filterBySince($select, $value, 'added');
                    break;
                case 'is_spam';
                case 'email':
                case 'name';
                case 'message';
                case 'path';
                case 'ip';
                case 'user_agent';
                    $select->where($alias . '.' . $key . ' = ?', $value);
                    break;
            }
        }

        // If we returning the data itself, we need to group by the record id.
        $select->group('simple_contacts.id');
    }
}
