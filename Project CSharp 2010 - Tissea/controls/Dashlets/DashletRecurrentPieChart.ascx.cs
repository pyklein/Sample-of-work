using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Telerik.Charting;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.controls.Dashlets
{
    public partial class DashletRecurrentPieChart : System.Web.UI.UserControl
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                ChartSeries series = new ChartSeries("Recurrent Activities", ChartSeriesType.Pie);

                var unplannedActivities = ActivitiesManager.GetLiveActivitiesFromView().Count(
                        a => a.ModuleId.ToString() == "080A4104-A4E6-4443-8E24-123EB9A5E0EA"
                        && a.ProgrammeId.ToString() == "44D576CB-B609-400F-A6DF-729C78061FB6"
                        && a.WorkflowState == WorkflowStatus.New
                    );

                series.AddItem((Double)unplannedActivities, "Unplanned Activities");

                var plannedActivities = ActivitiesManager.GetLiveActivitiesFromView().Count(
                        a => a.ModuleId.ToString() == "080A4104-A4E6-4443-8E24-123EB9A5E0EA"
                        && a.ProgrammeId.ToString() == "44D576CB-B609-400F-A6DF-729C78061FB6"
                        && a.WorkflowState == WorkflowStatus.Planned
                    );

                series.AddItem((Double)plannedActivities, "Planned Activities");

                var startedCompleteActivities = ActivitiesManager.GetLiveActivitiesFromView().Count(
                        a => a.ModuleId.ToString() == "080A4104-A4E6-4443-8E24-123EB9A5E0EA"
                        && a.ProgrammeId.ToString() == "44D576CB-B609-400F-A6DF-729C78061FB6"
                        && a.WorkflowState == WorkflowStatus.Started
                        && a.Completed == true
                    );

                series.AddItem((Double)startedCompleteActivities, "Completed Unchecked Activities");

                chartRecurrentPie.Series.Add(series);

                chartRecurrentPie.ChartTitle.TextBlock.Text = "SP Recurrent Activities";
            }
        }
    }
}