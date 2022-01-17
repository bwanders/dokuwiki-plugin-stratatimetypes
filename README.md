Strata Time Types
=================

__This dokuwiki plugin is no longer maintained. Due to time constraints and no longer using this plugin myself, I can no longer properly maintain it.__

This plugin provides additional date and time types for the [Strata](https://github.com/bwanders/dokuwiki-strata) dokuwiki plugin.

At the moment, this plugin only provides the `relativedate` type.

relativedate
------------

The relativedate type can be used to compare and display dates relative to the current time. This is useful when you want to display how long ago something was, how much time you'll still have to finish something, or to build lists of things happening within the next day, week or month.

The displayed time difference on opened wiki pages will automatically update even if you leave the page open for a long time. This prevents your from looking at a deadline and thinking there's still 7 hours left while really there's only 2 left.

To explain how to use this, let's assume that you have entered multiple tasks in your wiki that are defined like this:

```
<data task>
Deadline [date]: 2015-08-14
</data>
```

Now, when you want to make a table of upcoming items, you want to compare these items to the current time. You also want to display the amount of time you have to finish the tasks:

```
<table ?task ?deadline [date] ?deadline [relativedate] "Due in">
-- find all tasks and their associated deadlines
?task is a: task
?task Deadline[date]: ?deadline

-- only want deadlines that are less than seven days in the future
?deadline [relativedate] < now +7 days
</table>
```

This is a normal strata table. The trick is using the relativedate type:

  - Used in the comparison it will convert the `now +7 days` value to a time that can be used to compare against the stored times from the tasks.
  - Used as the type of the "Due in" column it will display the difference between the current time and the deadline. If that deadlines is in the future, it will say something like "in 4 days", if it is in the past it will say something like "4 days ago".


Note: On pages where you have a table or list that filters on a relative date, you might want to add the `~~NOCACHE~~` directive to tell dokuwiki never to cache the output of the page.
